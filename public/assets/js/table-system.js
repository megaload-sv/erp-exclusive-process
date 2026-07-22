(() => {
    'use strict';

    const STORAGE_KEY = 'traceops.table.preferences';
    const DENSITIES = ['compact', 'comfortable', 'spacious'];

    const normalize = (value) => value
        .toLocaleLowerCase('es')
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .trim();

    const readPreferences = () => {
        try {
            return JSON.parse(localStorage.getItem(STORAGE_KEY) || '{"tables":{}}');
        } catch (error) {
            return { tables: {} };
        }
    };

    const writePreferences = (preferences) => {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(preferences));
        } catch (error) {
            // Storage may be unavailable in private browsing or restricted contexts.
        }
    };

    class TraceOpsTable {
        constructor(container) {
            this.container = container;
            this.table = container.querySelector('table');
            this.tableId = container.dataset.tableId || this.table?.id || 'enterprise-table';
            this.section = container.closest('.to-table-section');
            this.toolbar = this.section?.querySelector('[data-table-toolbar]');
            this.manager = this.section?.querySelector(`[data-column-manager][data-table-target="${CSS.escape(this.tableId)}"]`);
            this.densitySelector = this.section?.querySelector(`[data-density-selector][data-table-target="${CSS.escape(this.tableId)}"]`);

            this.bindEvents();
            this.loadColumnPreferences();
            this.loadDensityPreference();
            this.updateSelectionState();
            this.updateResultState();
        }

        getRows() {
            return [...this.container.querySelectorAll('[data-table-row]')];
        }

        bindEvents() {
            this.section?.addEventListener('input', (event) => {
                const target = event.target;

                if (target instanceof HTMLInputElement && target.matches('[data-table-search]')) {
                    this.filter(target.value);
                }

                if (target instanceof HTMLInputElement && target.matches('[data-column-search]')) {
                    this.filterColumnOptions(target.value);
                }
            });

            this.section?.addEventListener('change', (event) => {
                const target = event.target;

                if (!(target instanceof HTMLInputElement)) {
                    return;
                }

                if (target.matches('[data-table-select-all]')) {
                    this.getRows().filter((row) => !row.hidden).forEach((row) => {
                        const checkbox = row.querySelector('[data-table-select-row]');
                        if (checkbox instanceof HTMLInputElement) {
                            checkbox.checked = target.checked;
                        }
                    });
                    this.updateSelectionState();
                }

                if (target.matches('[data-table-select-row]')) {
                    this.updateSelectionState();
                }

                if (target.matches('[data-column-toggle]')) {
                    this.setColumnVisibility(target.value, target.checked);
                    this.saveColumnPreferences();
                }

                if (target.matches('[data-density-option]')) {
                    this.setDensity(target.value);
                    this.saveDensityPreference(target.value);
                }
            });

            this.section?.addEventListener('click', (event) => {
                const target = event.target instanceof Element ? event.target : null;
                const sortButton = target?.closest('[data-table-sort]');
                const clearButton = target?.closest('[data-table-clear-search]');
                const showAllButton = target?.closest('[data-column-show-all]');
                const resetButton = target?.closest('[data-column-reset]');
                const densityResetButton = target?.closest('[data-density-reset]');

                if (sortButton instanceof HTMLButtonElement) {
                    this.sort(sortButton);
                }

                if (clearButton instanceof HTMLButtonElement) {
                    const input = this.section?.querySelector('[data-table-search]');
                    if (input instanceof HTMLInputElement) {
                        input.value = '';
                        this.filter('');
                        input.focus();
                    }
                }

                if (showAllButton instanceof HTMLButtonElement) {
                    this.manager?.querySelectorAll('[data-column-toggle]').forEach((checkbox) => {
                        if (checkbox instanceof HTMLInputElement) {
                            checkbox.checked = true;
                            this.setColumnVisibility(checkbox.value, true);
                        }
                    });
                    this.saveColumnPreferences();
                }

                if (resetButton instanceof HTMLButtonElement) {
                    this.resetColumnPreferences();
                }

                if (densityResetButton instanceof HTMLButtonElement) {
                    this.resetDensityPreference();
                }
            });
        }

        filter(value) {
            const query = normalize(value);

            this.getRows().forEach((row) => {
                row.hidden = query !== '' && !normalize(row.textContent || '').includes(query);
            });

            this.updateResultState();
        }

        sort(button) {
            const key = button.dataset.tableSort;

            if (!this.table || !key) {
                return;
            }

            const current = button.getAttribute('aria-sort');
            const next = current === 'ascending' ? 'descending' : 'ascending';
            const direction = next === 'ascending' ? 1 : -1;
            const rows = this.getRows();

            rows.sort((left, right) => {
                const leftValue = left.querySelector(`[data-column="${CSS.escape(key)}"]`)?.textContent?.trim() || '';
                const rightValue = right.querySelector(`[data-column="${CSS.escape(key)}"]`)?.textContent?.trim() || '';
                return leftValue.localeCompare(rightValue, 'es', { numeric: true, sensitivity: 'base' }) * direction;
            });

            rows.forEach((row) => this.table.tBodies[0]?.appendChild(row));

            this.table.querySelectorAll('[data-table-sort]').forEach((sortButton) => {
                const active = sortButton === button;
                sortButton.setAttribute('aria-sort', active ? next : 'none');
                const icon = sortButton.querySelector('.to-table__sort-icon');
                if (icon) {
                    icon.textContent = active ? (next === 'ascending' ? '↑' : '↓') : '↕';
                }
            });
        }

        updateSelectionState() {
            const rows = this.getRows().filter((row) => !row.hidden);
            const checkboxes = rows
                .map((row) => row.querySelector('[data-table-select-row]'))
                .filter((checkbox) => checkbox instanceof HTMLInputElement);
            const selected = checkboxes.filter((checkbox) => checkbox.checked);
            const selectAll = this.container.querySelector('[data-table-select-all]');
            const bulkAction = this.toolbar?.querySelector('[data-table-bulk-action]');
            const count = this.toolbar?.querySelector('[data-table-selection-count]');

            this.getRows().forEach((row) => {
                const checkbox = row.querySelector('[data-table-select-row]');
                row.setAttribute('aria-selected', checkbox?.checked ? 'true' : 'false');
            });

            if (selectAll instanceof HTMLInputElement) {
                selectAll.checked = checkboxes.length > 0 && selected.length === checkboxes.length;
                selectAll.indeterminate = selected.length > 0 && selected.length < checkboxes.length;
            }

            if (bulkAction instanceof HTMLButtonElement) {
                bulkAction.disabled = selected.length === 0;
            }

            if (count) {
                count.textContent = String(selected.length);
            }
        }

        updateResultState() {
            const rows = this.getRows();
            const visibleRows = rows.filter((row) => !row.hidden);
            const resultCount = this.section?.querySelector('[data-table-result-count]');
            let emptyRow = this.container.querySelector('[data-table-filter-empty]');

            if (resultCount) {
                resultCount.textContent = String(visibleRows.length);
            }

            if (visibleRows.length === 0 && rows.length > 0 && this.table) {
                if (!emptyRow) {
                    emptyRow = document.createElement('tr');
                    emptyRow.setAttribute('data-table-filter-empty', '');
                    const cell = document.createElement('td');
                    cell.colSpan = this.table.tHead?.rows[0]?.cells.length || 1;
                    cell.innerHTML = '<div class="to-table-empty"><strong>Sin resultados</strong><span>Prueba con otro término de búsqueda.</span></div>';
                    emptyRow.appendChild(cell);
                    this.table.tBodies[0]?.appendChild(emptyRow);
                }
            } else {
                emptyRow?.remove();
            }

            this.updateSelectionState();
        }

        setColumnVisibility(key, visible) {
            this.table?.querySelectorAll(`[data-column="${CSS.escape(key)}"]`).forEach((cell) => {
                cell.hidden = !visible;
            });
        }

        filterColumnOptions(value) {
            const query = normalize(value);
            this.manager?.querySelectorAll('[data-column-option]').forEach((option) => {
                const label = normalize(option.dataset.columnLabel || option.textContent || '');
                option.hidden = query !== '' && !label.includes(query);
            });
        }

        loadColumnPreferences() {
            const tablePreferences = readPreferences().tables?.[this.tableId]?.columns || {};

            this.manager?.querySelectorAll('[data-column-toggle]').forEach((checkbox) => {
                if (!(checkbox instanceof HTMLInputElement)) {
                    return;
                }

                if (Object.prototype.hasOwnProperty.call(tablePreferences, checkbox.value)) {
                    checkbox.checked = Boolean(tablePreferences[checkbox.value]);
                }

                this.setColumnVisibility(checkbox.value, checkbox.checked);
            });
        }

        saveColumnPreferences() {
            const preferences = readPreferences();
            preferences.tables ||= {};
            preferences.tables[this.tableId] ||= {};
            preferences.tables[this.tableId].columns = {};

            this.manager?.querySelectorAll('[data-column-toggle]').forEach((checkbox) => {
                if (checkbox instanceof HTMLInputElement) {
                    preferences.tables[this.tableId].columns[checkbox.value] = checkbox.checked;
                }
            });

            writePreferences(preferences);
        }

        resetColumnPreferences() {
            const preferences = readPreferences();
            if (preferences.tables?.[this.tableId]) {
                delete preferences.tables[this.tableId].columns;
                writePreferences(preferences);
            }

            this.manager?.querySelectorAll('[data-column-toggle]').forEach((checkbox) => {
                if (checkbox instanceof HTMLInputElement) {
                    checkbox.checked = checkbox.defaultChecked;
                    this.setColumnVisibility(checkbox.value, checkbox.checked);
                }
            });
        }

        setDensity(value) {
            const density = DENSITIES.includes(value) ? value : 'comfortable';
            this.container.dataset.tableDensity = density;

            this.densitySelector?.querySelectorAll('[data-density-option]').forEach((option) => {
                if (option instanceof HTMLInputElement) {
                    option.checked = option.value === density;
                }
            });

            const selected = this.densitySelector?.querySelector(`[data-density-option][value="${CSS.escape(density)}"]`);
            const label = selected?.closest('label')?.querySelector('strong')?.textContent?.trim();
            const currentLabel = this.densitySelector?.querySelector('[data-density-label]');
            if (currentLabel && label) {
                currentLabel.textContent = label;
            }
        }

        loadDensityPreference() {
            const savedDensity = readPreferences().tables?.[this.tableId]?.density;
            const defaultOption = this.densitySelector?.querySelector('[data-density-option]:checked');
            const density = DENSITIES.includes(savedDensity) ? savedDensity : defaultOption?.value || 'comfortable';
            this.setDensity(density);
        }

        saveDensityPreference(value) {
            if (!DENSITIES.includes(value)) {
                return;
            }

            const preferences = readPreferences();
            preferences.tables ||= {};
            preferences.tables[this.tableId] ||= {};
            preferences.tables[this.tableId].density = value;
            writePreferences(preferences);
        }

        resetDensityPreference() {
            const preferences = readPreferences();
            if (preferences.tables?.[this.tableId]) {
                delete preferences.tables[this.tableId].density;
                writePreferences(preferences);
            }

            const defaultOption = [...(this.densitySelector?.querySelectorAll('[data-density-option]') || [])]
                .find((option) => option instanceof HTMLInputElement && option.defaultChecked);
            this.setDensity(defaultOption?.value || 'comfortable');
        }
    }

    document.querySelectorAll('[data-table-container]').forEach((container) => {
        new TraceOpsTable(container);
    });
})();
