(() => {
    'use strict';

    const updateSelectionState = (container) => {
        const rows = [...container.querySelectorAll('[data-table-select-row]')];
        const selected = rows.filter((checkbox) => checkbox.checked);
        const selectAll = container.querySelector('[data-table-select-all]');
        const toolbar = container.closest('.to-table-section')?.querySelector('[data-table-toolbar]');
        const bulkAction = toolbar?.querySelector('[data-table-bulk-action]');
        const count = toolbar?.querySelector('[data-table-selection-count]');

        rows.forEach((checkbox) => {
            const row = checkbox.closest('[data-table-row]');
            row?.setAttribute('aria-selected', checkbox.checked ? 'true' : 'false');
        });

        if (selectAll instanceof HTMLInputElement) {
            selectAll.checked = rows.length > 0 && selected.length === rows.length;
            selectAll.indeterminate = selected.length > 0 && selected.length < rows.length;
        }

        if (bulkAction instanceof HTMLButtonElement) {
            bulkAction.disabled = selected.length === 0;
        }

        if (count) {
            count.textContent = String(selected.length);
        }
    };

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
            container.querySelectorAll('[data-table-select-row]').forEach((checkbox) => {
                if (checkbox instanceof HTMLInputElement) {
                    checkbox.checked = target.checked;
                }
            });
        }

        updateSelectionState(container);
    });

    document.addEventListener('click', (event) => {
        const button = event.target instanceof Element
            ? event.target.closest('[data-table-sort]')
            : null;

        if (!(button instanceof HTMLButtonElement)) {
            return;
        }

        const table = button.closest('table');
        const current = button.getAttribute('aria-sort');
        const next = current === 'ascending' ? 'descending' : 'ascending';

        table?.querySelectorAll('[data-table-sort]').forEach((sortButton) => {
            sortButton.setAttribute('aria-sort', sortButton === button ? next : 'none');
            const icon = sortButton.querySelector('.to-table__sort-icon');
            if (icon) {
                icon.textContent = sortButton === button
                    ? (next === 'ascending' ? '↑' : '↓')
                    : '↕';
            }
        });
    });
})();
