(() => {
    'use strict';

    const sanitizeFileName = (value) => (value || 'export')
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/[^a-zA-Z0-9_-]+/g, '-')
        .replace(/^-+|-+$/g, '')
        .toLowerCase() || 'export';

    const csvEscape = (value) => {
        const normalized = String(value ?? '').replace(/\s+/g, ' ').trim();
        return `"${normalized.replace(/"/g, '""')}"`;
    };

    const getExportColumns = (table) => [...(table.tHead?.rows[0]?.cells || [])]
        .filter((cell) => !cell.hidden && cell.dataset.exportable !== 'false');

    const getExportRows = (table, scope) => [...table.querySelectorAll('[data-table-row]')]
        .filter((row) => {
            if (row.hidden) {
                return false;
            }

            if (scope !== 'selected') {
                return true;
            }

            const checkbox = row.querySelector('[data-table-select-row]');
            return checkbox instanceof HTMLInputElement && checkbox.checked;
        });

    const buildExportPayload = (table, scope) => {
        const columns = getExportColumns(table);
        const keys = columns.map((column) => column.dataset.column || '');
        const headers = columns.map((column) => column.textContent || '');
        const rows = getExportRows(table, scope).map((row) => keys.map((key) => {
            const cell = row.querySelector(`[data-column="${CSS.escape(key)}"]`);
            return cell?.textContent || '';
        }));

        return { headers, rows, keys, scope };
    };

    const downloadCsv = (payload, fileName) => {
        const lines = [payload.headers, ...payload.rows]
            .map((row) => row.map(csvEscape).join(','));
        const blob = new Blob([`\uFEFF${lines.join('\r\n')}`], { type: 'text/csv;charset=utf-8' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `${sanitizeFileName(fileName)}.csv`;
        document.body.appendChild(link);
        link.click();
        link.remove();
        URL.revokeObjectURL(url);
    };

    document.addEventListener('click', (event) => {
        const target = event.target instanceof Element ? event.target.closest('[data-table-export]') : null;

        if (!(target instanceof HTMLButtonElement)) {
            return;
        }

        const menu = target.closest('[data-export-menu]');
        const tableId = menu?.dataset.tableTarget;
        const table = tableId ? document.getElementById(tableId) : null;
        const status = menu?.querySelector('[data-export-status]');
        const format = target.dataset.tableExport || 'csv';
        const scope = target.dataset.exportScope || 'visible';

        if (!(table instanceof HTMLTableElement)) {
            if (status) status.textContent = 'No se encontró la tabla para exportar.';
            return;
        }

        const payload = buildExportPayload(table, scope);

        if (payload.rows.length === 0) {
            if (status) status.textContent = scope === 'selected'
                ? 'Selecciona al menos un registro.'
                : 'No hay registros visibles para exportar.';
            return;
        }

        if (format === 'csv') {
            downloadCsv(payload, menu?.dataset.exportFilename || tableId);
            if (status) status.textContent = `${payload.rows.length} registros exportados a CSV.`;
            return;
        }

        table.dispatchEvent(new CustomEvent('traceops:table-export', {
            bubbles: true,
            detail: {
                tableId,
                format,
                fileName: menu?.dataset.exportFilename || tableId,
                ...payload,
            },
        }));

        if (status) status.textContent = `${format.toUpperCase()} requiere un adaptador de exportación.`;
    });
})();
