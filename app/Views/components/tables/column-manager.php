<?php

/**
 * TraceOps column manager component.
 *
 * @var string|null $tableId
 * @var array<int, array<string, mixed>>|null $columns
 */

$tableId = isset($tableId) && is_string($tableId) && $tableId !== ''
    ? $tableId
    : 'enterprise-table';
$columns = isset($columns) && is_array($columns) ? $columns : [];
$manageableColumns = [];

foreach ($columns as $column) {
    if (! is_array($column) || ($column['hideable'] ?? true) !== true) {
        continue;
    }

    $key = trim((string) ($column['key'] ?? ''));
    if ($key === '') {
        continue;
    }

    $label = trim((string) ($column['label'] ?? $key));
    $manageableColumns[] = [
        'key' => $key,
        'label' => $label !== '' ? $label : $key,
        'visible' => (bool) ($column['visible'] ?? true),
    ];
}
?>
<details class="to-column-manager" data-column-manager data-table-target="<?= esc($tableId) ?>">
    <summary class="to-btn to-btn--secondary" aria-label="Personalizar columnas de la tabla">
        Columnas
    </summary>

    <div class="to-column-manager__panel">
        <div class="to-column-manager__header">
            <div>
                <strong>Personalizar columnas</strong>
                <span>Selecciona la información que deseas visualizar.</span>
            </div>
        </div>

        <label class="to-sr-only" for="<?= esc($tableId) ?>-column-search">Buscar columna</label>
        <input id="<?= esc($tableId) ?>-column-search"
               class="to-input"
               type="search"
               placeholder="Buscar columna..."
               autocomplete="off"
               data-column-search>

        <div class="to-column-manager__options" data-column-options>
            <?php foreach ($manageableColumns as $column): ?>
                <label class="to-column-manager__option" data-column-option data-column-label="<?= esc($column['label']) ?>">
                    <input type="checkbox"
                           value="<?= esc($column['key']) ?>"
                           data-column-toggle
                           <?= $column['visible'] ? 'checked' : '' ?>>
                    <span><?= esc($column['label']) ?></span>
                </label>
            <?php endforeach ?>
        </div>

        <div class="to-column-manager__footer">
            <button type="button" class="to-btn to-btn--ghost" data-column-show-all>Mostrar todas</button>
            <button type="button" class="to-btn to-btn--ghost" data-column-reset>Restablecer</button>
        </div>
    </div>
</details>
