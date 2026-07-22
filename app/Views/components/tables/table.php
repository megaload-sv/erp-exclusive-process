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
 * @var bool|null $loading
 * @var int|null $skeletonRows
 * @var string|null $errorTitle
 * @var string|null $errorDescription
 * @var string|null $emptyTitle
 * @var string|null $emptyDescription
 */

$id = $id ?? 'enterprise-table';
$caption = $caption ?? null;
$columns = $columns ?? [];
$rows = $rows ?? [];
$selectable = $selectable ?? false;
$rowKey = $rowKey ?? 'id';
$loading = $loading ?? false;
$skeletonRows = max(1, $skeletonRows ?? 5);
$errorTitle = $errorTitle ?? null;
$errorDescription = $errorDescription ?? 'Intenta nuevamente o actualiza la página.';
$emptyTitle = $emptyTitle ?? 'No hay registros disponibles';
$emptyDescription = $emptyDescription ?? 'Los registros aparecerán aquí cuando estén disponibles.';
$columnCount = count($columns) + ($selectable ? 1 : 0);
?>
<div class="to-table-container<?= $loading ? ' is-loading' : '' ?>"
     data-table-container
     data-table-id="<?= esc($id) ?>"
     aria-busy="<?= $loading ? 'true' : 'false' ?>">
    <div class="to-table-scroll" tabindex="0" role="region" aria-label="<?= esc($caption ?? 'Tabla de datos') ?>">
        <table id="<?= esc($id) ?>" class="to-table">
            <?php if ($caption !== null): ?>
                <caption class="to-sr-only"><?= esc($caption) ?></caption>
            <?php endif ?>
            <thead>
            <tr>
                <?php if ($selectable): ?>
                    <th class="to-table__selection" scope="col" data-exportable="false">
                        <input type="checkbox"
                               class="to-table__checkbox"
                               data-table-select-all
                               aria-label="Seleccionar todos los registros"
                               <?= $loading || $errorTitle !== null ? 'disabled' : '' ?>>
                    </th>
                <?php endif ?>
                <?php foreach ($columns as $column): ?>
                    <?php
                    $key = (string) ($column['key'] ?? '');
                    $label = (string) ($column['label'] ?? $key);
                    $sortable = (bool) ($column['sortable'] ?? false);
                    $visible = (bool) ($column['visible'] ?? true);
                    $exportable = (bool) ($column['exportable'] ?? true);
                    $align = in_array(($column['align'] ?? 'start'), ['start', 'center', 'end'], true)
                        ? $column['align']
                        : 'start';
                    $width = isset($column['width']) ? (string) $column['width'] : null;
                    ?>
                    <th scope="col"
                        class="to-table__cell--<?= esc($align) ?>"
                        data-column="<?= esc($key) ?>"
                        data-exportable="<?= $exportable ? 'true' : 'false' ?>"
                        <?= $visible ? '' : 'hidden' ?>
                        <?= $width !== null ? 'style="width:' . esc($width) . '"' : '' ?>>
                        <?php if ($sortable): ?>
                            <button type="button"
                                    class="to-table__sort"
                                    data-table-sort="<?= esc($key) ?>"
                                    aria-sort="none"
                                    <?= $loading || $errorTitle !== null ? 'disabled' : '' ?>>
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
            <?php if ($loading): ?>
                <?php for ($rowIndex = 0; $rowIndex < $skeletonRows; $rowIndex++): ?>
                    <tr class="to-table__skeleton-row" aria-hidden="true">
                        <?php if ($selectable): ?>
                            <td class="to-table__selection" data-exportable="false"><span class="to-skeleton to-skeleton--checkbox"></span></td>
                        <?php endif ?>
                        <?php foreach ($columns as $columnIndex => $column): ?>
                            <?php
                            $visible = (bool) ($column['visible'] ?? true);
                            $exportable = (bool) ($column['exportable'] ?? true);
                            ?>
                            <td data-column="<?= esc((string) ($column['key'] ?? '')) ?>"
                                data-exportable="<?= $exportable ? 'true' : 'false' ?>"
                                <?= $visible ? '' : 'hidden' ?>>
                                <span class="to-skeleton<?= $columnIndex === 1 ? ' to-skeleton--wide' : '' ?>"></span>
                            </td>
                        <?php endforeach ?>
                    </tr>
                <?php endfor ?>
            <?php elseif ($errorTitle !== null): ?>
                <tr>
                    <td colspan="<?= esc((string) max($columnCount, 1)) ?>">
                        <div class="to-table-state to-table-state--error" role="alert">
                            <span class="to-table-state__icon" aria-hidden="true">!</span>
                            <strong><?= esc($errorTitle) ?></strong>
                            <span><?= esc($errorDescription) ?></span>
                            <button type="button" class="to-btn to-btn--secondary" data-table-retry>Reintentar</button>
                        </div>
                    </td>
                </tr>
            <?php elseif ($rows === []): ?>
                <tr>
                    <td colspan="<?= esc((string) max($columnCount, 1)) ?>">
                        <div class="to-table-state">
                            <span class="to-table-state__icon" aria-hidden="true">–</span>
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
                            <td class="to-table__selection" data-exportable="false">
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
                            $visible = (bool) ($column['visible'] ?? true);
                            $exportable = (bool) ($column['exportable'] ?? true);
                            $align = in_array(($column['align'] ?? 'start'), ['start', 'center', 'end'], true)
                                ? $column['align']
                                : 'start';
                            $value = $row[$key] ?? '';
                            ?>
                            <td class="to-table__cell--<?= esc($align) ?>"
                                data-column="<?= esc($key) ?>"
                                data-exportable="<?= $exportable ? 'true' : 'false' ?>"
                                <?= $visible ? '' : 'hidden' ?>>
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
