<?php

/**
 * TraceOps column manager component.
 *
 * @var string $tableId
 * @var array<int, array<string, mixed>> $columns
 */

$tableId = $tableId ?? 'enterprise-table';
$columns = $columns ?? [];
$manageableColumns = array_values(array_filter($columns, static fn (array $column): bool => ($column['hideable'] ?? true) === true));
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
                <?php
                $key = (string) ($column['key'] ?? '');
                $label = (string) ($column['label'] ?? $key);
                $visible = (bool) ($column['visible'] ?? true);
                ?>
                <label class="to-column-manager__option" data-column-option data-column-label="<?= esc($label) ?>">
                    <input type="checkbox"
                           value="<?= esc($key) ?>"
                           data-column-toggle
                           <?= $visible ? 'checked' : '' ?>>
                    <span><?= esc($label) ?></span>
                </label>
            <?php endforeach ?>
        </div>

        <div class="to-column-manager__footer">
            <button type="button" class="to-btn to-btn--ghost" data-column-show-all>Mostrar todas</button>
            <button type="button" class="to-btn to-btn--ghost" data-column-reset>Restablecer</button>
        </div>
    </div>
</details>
