<?php

/**
 * TraceOps enterprise table component.
 *
 * @var string|null $id
 * @var string|null $caption
 * @var array<int, array<string, mixed>> $columns
 * @var array<int, array<string, mixed>> $rows
 * @var bool|null $selectable
 * @var string|null $rowKey
 * @var string|null $emptyTitle
 * @var string|null $emptyDescription
 */

$id = $id ?? 'enterprise-table';
$caption = $caption ?? null;
$columns = $columns ?? [];
$rows = $rows ?? [];
$selectable = $selectable ?? false;
$rowKey = $rowKey ?? 'id';
$emptyTitle = $emptyTitle ?? 'No hay registros disponibles';
$emptyDescription = $emptyDescription ?? 'Los registros aparecerán aquí cuando estén disponibles.';
$columnCount = count($columns) + ($selectable ? 1 : 0);
?>
<div class="to-table-container" data-table-container>
    <div class="to-table-scroll" tabindex="0" role="region" aria-label="<?= esc($caption ?? 'Tabla de datos') ?>">
        <table id="<?= esc($id) ?>" class="to-table">
            <?php if ($caption !== null): ?>
                <caption class="to-sr-only"><?= esc($caption) ?></caption>
            <?php endif ?>
            <thead>
            <tr>
                <?php if ($selectable): ?>
                    <th class="to-table__selection" scope="col">
                        <input type="checkbox"
                               class="to-table__checkbox"
                               data-table-select-all
                               aria-label="Seleccionar todos los registros">
                    </th>
                <?php endif ?>
                <?php foreach ($columns as $column): ?>
                    <?php
                    $key = (string) ($column['key'] ?? '');
                    $label = (string) ($column['label'] ?? $key);
                    $sortable = (bool) ($column['sortable'] ?? false);
                    $align = in_array(($column['align'] ?? 'start'), ['start', 'center', 'end'], true)
                        ? $column['align']
                        : 'start';
                    ?>
                    <th scope="col" class="to-table__cell--<?= esc($align) ?>">
                        <?php if ($sortable): ?>
                            <button type="button"
                                    class="to-table__sort"
                                    data-table-sort="<?= esc($key) ?>"
                                    aria-sort="none">
                                <span><?= esc($label) ?></span>
                                <span class="to-table__sort-icon" aria-hidden="true">↕</span>
                            </button>
                        <?php else: ?>
                            <?= esc($label) ?>
                        <?php endif ?>
                    </th>
                <?php endforeach ?>
            </tr>
            </thead>
            <tbody>
            <?php if ($rows === []): ?>
                <tr>
                    <td colspan="<?= esc((string) max($columnCount, 1)) ?>">
                        <div class="to-table-empty">
                            <strong><?= esc($emptyTitle) ?></strong>
                            <span><?= esc($emptyDescription) ?></span>
                        </div>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($rows as $row): ?>
                    <?php $rowId = (string) ($row[$rowKey] ?? ''); ?>
                    <tr data-table-row data-row-id="<?= esc($rowId) ?>">
                        <?php if ($selectable): ?>
                            <td class="to-table__selection">
                                <input type="checkbox"
                                       class="to-table__checkbox"
                                       name="selected_rows[]"
                                       value="<?= esc($rowId) ?>"
                                       data-table-select-row
                                       aria-label="Seleccionar registro <?= esc($rowId) ?>">
                            </td>
                        <?php endif ?>
                        <?php foreach ($columns as $column): ?>
                            <?php
                            $key = (string) ($column['key'] ?? '');
                            $align = in_array(($column['align'] ?? 'start'), ['start', 'center', 'end'], true)
                                ? $column['align']
                                : 'start';
                            $value = $row[$key] ?? '';
                            ?>
                            <td class="to-table__cell--<?= esc($align) ?>" data-column="<?= esc($key) ?>">
                                <?php if (isset($column['render']) && is_callable($column['render'])): ?>
                                    <?= $column['render']($value, $row) ?>
                                <?php else: ?>
                                    <?= esc((string) $value) ?>
                                <?php endif ?>
                            </td>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
            </tbody>
        </table>
    </div>
</div>
