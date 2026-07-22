<?php

/**
 * TraceOps table export menu.
 *
 * @var string $tableId
 * @var string|null $fileName
 */

$tableId = $tableId ?? 'enterprise-table';
$fileName = $fileName ?? $tableId;
?>
<details class="to-export-menu"
         data-export-menu
         data-table-target="<?= esc($tableId) ?>"
         data-export-filename="<?= esc($fileName) ?>">
    <summary class="to-btn to-btn--secondary">
        Exportar
    </summary>

    <div class="to-export-menu__panel">
        <header class="to-export-menu__header">
            <strong>Exportar datos</strong>
            <span>Descarga los registros visibles o seleccionados.</span>
        </header>

        <div class="to-export-menu__options">
            <button type="button" class="to-export-menu__option" data-table-export="csv" data-export-scope="visible">
                <span>
                    <strong>CSV visible</strong>
                    <small>Respeta búsqueda y columnas visibles.</small>
                </span>
                <span aria-hidden="true">CSV</span>
            </button>

            <button type="button" class="to-export-menu__option" data-table-export="csv" data-export-scope="selected">
                <span>
                    <strong>CSV seleccionado</strong>
                    <small>Exporta únicamente las filas marcadas.</small>
                </span>
                <span aria-hidden="true">CSV</span>
            </button>

            <button type="button" class="to-export-menu__option" data-table-export="xlsx" data-export-scope="visible">
                <span>
                    <strong>Excel</strong>
                    <small>Hook preparado para integración XLSX.</small>
                </span>
                <span aria-hidden="true">XLSX</span>
            </button>

            <button type="button" class="to-export-menu__option" data-table-export="pdf" data-export-scope="visible">
                <span>
                    <strong>PDF</strong>
                    <small>Hook preparado para reportes empresariales.</small>
                </span>
                <span aria-hidden="true">PDF</span>
            </button>
        </div>

        <p class="to-export-menu__status" data-export-status aria-live="polite"></p>
    </div>
</details>
