(() => {
    'use strict';

    const normalize = (value) => value
        .toLocaleLowerCase('es')
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .trim();

    const getRows = (container) => [...container.querySelectorAll('[data-table-row]')];

    const updateSelectionState = (container) => {
        const rows = getRows(container).filter((row) => !row.hidden);
        const checkboxes = rows
            .map((row) => row.querySelector('[data-table-select-row]'))
            .filter((checkbox) => checkbox instanceof HTMLInputElement);
        const selected = checkboxes.filter((checkbox) => checkbox.checked);
        const selectAll = container.querySelector('[data-table-select-all]');
        const section = container.closest('.to-table-section');
        const toolbar = section?.querySelector('[data-table-toolbar]');
        const bulkAction = toolbar?.querySelector('[data-table-bulk-action]');
        const count = toolbar?.querySelector('[data-table-selection-count]');

        getRows(container).forEach((row) => {
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
    };

    const updateResultState = (container) => {
        const rows = getRows(container);
        const visibleRows = rows.filter((row) => !row.hidden);
        const table = container.querySelector('table');
        const section = container.closest('.to-table-section');
        const resultCount = section?.querySelector('[data-table-result-count]');
        let emptyRow = container.querySelector('[data-table-filter-empty]');

        if (resultCount) {
            resultCount.textContent = String(visibleRows.length);
        }

        if (visibleRows.length === 0 && rows.length > 0) {
            if (!emptyRow && table) {
                emptyRow = document.createElement('tr');
                emptyRow.setAttribute('data-table-filter-empty', '');
                const cell = document.createElement('td');
                cell.colSpan = table.tHead?.rows[0]?.cells.length || 1;
                cell.innerHTML = '<div class="to-table-empty"><strong>Sin resultados</strong><span>Prueba con otro término de búsqueda.</span></div>';
                emptyRow.appendChild(cell);
                table.tBodies[0]?.appendChild(emptyRow);
            }
        } else {
            emptyRow?.remove();
        }

        updateSelectionState(container);
    };

    const filterTable = (input) => {
        const section = input.closest('.to-table-section');
        const container = section?.querySelector('[data-table-container]');

        if (!container) {
            return;
        }

        const query = normalize(input.value);

        getRows(container).forEach((row) => {
            row.hidden = query !== '' && !normalize(row.textContent || '').includes(query);
        });

        updateResultState(container);
    };

    const sortTable = (button) => {
        const table = button.closest('table');
        const container = button.closest('[data-table-container]');
        const key = button.dataset.tableSort;

        if (!table || !container || !key) {
            return;
        }

        const current = button.getAttribute('aria-sort');
        const next = current === 'ascending' ? 'descending' : 'ascending';
        const rows = getRows(container);
        const direction = next === 'ascending' ? 1 : -1;

        rows.sort((left, right) => {
            const leftValue = left.querySelector(`[data-column="${CSS.escape(key)}"]`)?.textContent?.trim() || '';
            const rightValue = right.querySelector(`[data-column="${CSS.escape(key)}"]`)?.textContent?.trim() || '';
            return leftValue.localeCompare(rightValue, 'es', { numeric: true, sensitivity: 'base' }) * direction;
        });

        rows.forEach((row) => table.tBodies[0]?.appendChild(row));

        table.querySelectorAll('[data-table-sort]').forEach((sortButton) => {
            const active = sortButton === button;
            sortButton.setAttribute('aria-sort', active ? next : 'none');
            const icon = sortButton.querySelector('.to-table__sort-icon');
            if (icon) {
                icon.textContent = active ? (next === 'ascending' ? '↑' : '↓') : '↕';
            }
        });
    };

    document.addEventListener('input', (event) => {
        if (event.target instanceof HTMLInputElement && event.target.matches('[data-table-search]')) {
            filterTable(event.target);
        }
    });

    document.addEventListener('change', (event) => {
        const target = event.target;

        if (!(target instanceof HTMLInputElement)) {
            return;
        }

        const container = target.closest('[data-table-container]');

        if (!container) {
            return;
        }

        if (target.matches('[data-table-select-all]')) {
            getRows(container).filter((row) => !row.hidden).forEach((row) => {
                const checkbox = row.querySelector('[data-table-select-row]');
                if (checkbox instanceof HTMLInputElement) {
                    checkbox.checked = target.checked;
                }
            });
        }

        updateSelectionState(container);
    });

    document.addEventListener('click', (event) => {
        const target = event.target instanceof Element ? event.target : null;
        const sortButton = target?.closest('[data-table-sort]');
        const clearButton = target?.closest('[data-table-clear-search]');

        if (sortButton instanceof HTMLButtonElement) {
            sortTable(sortButton);
        }

        if (clearButton instanceof HTMLButtonElement) {
            const section = clearButton.closest('.to-table-section');
            const input = section?.querySelector('[data-table-search]');
            if (input instanceof HTMLInputElement) {
                input.value = '';
                filterTable(input);
                input.focus();
            }
        }
    });

    document.querySelectorAll('[data-table-container]').forEach(updateSelectionState);
})();