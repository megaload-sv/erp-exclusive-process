<?php

/**
 * TraceOps enterprise table component.
 *
 * @var string|null $id
 * @var string|null $caption
 * @var array<int, array<string, mixed>>|null $columns
 * @var array<int, array<string, mixed>>|null $rows
 * @var bool|null $selectable
 * @var string|null $rowKey
 * @var bool|null $loading
 * @var int|null $skeletonRows
 * @var string|null $errorTitle
 * @var string|null $errorDescription
 * @var string|null $emptyTitle
 * @var string|null $emptyDescription
 * @var array<int, array<string, mixed>>|null $contextActions
 */

$id = trim((string) ($id ?? 'enterprise-table'));
$id = $id !== '' ? $id : 'enterprise-table';
$caption = isset($caption) && trim((string) $caption) !== '' ? (string) $caption : null;
$rawColumns = is_array($columns ?? null) ? $columns : [];
$rows = array_values(array_filter(is_array($rows ?? null) ? $rows : [], 'is_array'));
$selectable = (bool) ($selectable ?? false);
$rowKey = trim((string) ($rowKey ?? 'id'));
$rowKey = $rowKey !== '' ? $rowKey : 'id';
$loading = (bool) ($loading ?? false);
$skeletonRows = max(1, (int) ($skeletonRows ?? 5));
$errorTitle = isset($errorTitle) && trim((string) $errorTitle) !== '' ? (string) $errorTitle : null;
$errorDescription = isset($errorDescription) && trim((string) $errorDescription) !== ''
    ? (string) $errorDescription
    : 'Intenta nuevamente o actualiza la página.';
$emptyTitle = isset($emptyTitle) && trim((string) $emptyTitle) !== ''
    ? (string) $emptyTitle
    : 'No hay registros disponibles';
$emptyDescription = isset($emptyDescription) && trim((string) $emptyDescription) !== ''
    ? (string) $emptyDescription
    : 'Los registros aparecerán aquí cuando estén disponibles.';
$contextActions = array_values(array_filter(is_array($contextActions ?? null) ? $contextActions : [], 'is_array'));

$columns = [];
foreach ($rawColumns as $column) {
    if (! is_array($column)) {
        continue;
    }

    $key = trim((string) ($column['key'] ?? ''));
    if ($key === '') {
        continue;
    }

    $requestedAlign = (string) ($column['align'] ?? 'start');
    $columns[] = [
        'key' => $key,
        'label' => (string) ($column['label'] ?? $key),
        'sortable' => (bool) ($column['sortable'] ?? false),
        'visible' => (bool) ($column['visible'] ?? true),
        'exportable' => (bool) ($column['exportable'] ?? true),
        'align' => in_array($requestedAlign, ['start', 'center', 'end'], true) ? $requestedAlign : 'start',
        'width' => isset($column['width']) && trim((string) $column['width']) !== '' ? (string) $column['width'] : null,
        'render' => isset($column['render']) && is_callable($column['render']) ? $column['render'] : null,
    ];
}

$hasContextMenu = $contextActions !== [] && ! $loading && $errorTitle === null && $rows !== [];
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
                        <input type="checkbox" class="to-table__checkbox" data-table-select-all
                               aria-label="Seleccionar todos los registros"
                               <?= $loading || $errorTitle !== null ? 'disabled' : '' ?>>
                    </th>
                <?php endif ?>
                <?php foreach ($columns as $column): ?>
                    <th scope="col" class="to-table__cell--<?= esc($column['align']) ?>"
                        data-column="<?= esc($column['key']) ?>"
                        data-exportable="<?= $column['exportable'] ? 'true' : 'false' ?>"
                        <?= $column['visible'] ? '' : 'hidden' ?>
                        <?= $column['width'] !== null ? 'style="width:' . esc($column['width']) . '"' : '' ?>>
                        <?php if ($column['sortable']): ?>
                            <button type="button" class="to-table__sort" data-table-sort="<?= esc($column['key']) ?>"
                                    aria-sort="none" <?= $loading || $errorTitle !== null ? 'disabled' : '' ?>>
                                <span><?= esc($column['label']) ?></span>
                                <span class="to-table__sort-icon" aria-hidden="true">↕</span>
                            </button>
                        <?php else: ?>
                            <?= esc($column['label']) ?>
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
                            <td data-column="<?= esc($column['key']) ?>"
                                data-exportable="<?= $column['exportable'] ? 'true' : 'false' ?>"
                                <?= $column['visible'] ? '' : 'hidden' ?>>
                                <span class="to-skeleton<?= $columnIndex === 1 ? ' to-skeleton--wide' : '' ?>"></span>
                            </td>
                        <?php endforeach ?>
                    </tr>
                <?php endfor ?>
            <?php elseif ($errorTitle !== null): ?>
                <tr><td colspan="<?= esc((string) max($columnCount, 1)) ?>">
                    <div class="to-table-state to-table-state--error" role="alert">
                        <span class="to-table-state__icon" aria-hidden="true">!</span>
                        <strong><?= esc($errorTitle) ?></strong><span><?= esc($errorDescription) ?></span>
                        <button type="button" class="to-btn to-btn--secondary" data-table-retry>Reintentar</button>
                    </div>
                </td></tr>
            <?php elseif ($rows === []): ?>
                <tr><td colspan="<?= esc((string) max($columnCount, 1)) ?>">
                    <div class="to-table-state"><span class="to-table-state__icon" aria-hidden="true">–</span>
                        <strong><?= esc($emptyTitle) ?></strong><span><?= esc($emptyDescription) ?></span>
                    </div>
                </td></tr>
            <?php else: ?>
                <?php foreach ($rows as $row): ?>
                    <?php $rowId = is_scalar($row[$rowKey] ?? '') ? (string) ($row[$rowKey] ?? '') : ''; ?>
                    <tr data-table-row data-row-id="<?= esc($rowId) ?>"
                        <?= $hasContextMenu ? 'tabindex="0" aria-haspopup="menu"' : '' ?>>
                        <?php if ($selectable): ?>
                            <td class="to-table__selection" data-exportable="false">
                                <input type="checkbox" class="to-table__checkbox" name="selected_rows[]"
                                       value="<?= esc($rowId) ?>" data-table-select-row
                                       aria-label="Seleccionar registro <?= esc($rowId) ?>">
                            </td>
                        <?php endif ?>
                        <?php foreach ($columns as $column): ?>
                            <?php $value = $row[$column['key']] ?? ''; ?>
                            <td class="to-table__cell--<?= esc($column['align']) ?>"
                                data-column="<?= esc($column['key']) ?>"
                                data-exportable="<?= $column['exportable'] ? 'true' : 'false' ?>"
                                <?= $column['visible'] ? '' : 'hidden' ?>>
                                <?php if ($column['render'] !== null): ?>
                                    <?= $column['render']($value, $row) ?>
                                <?php else: ?>
                                    <?= esc(is_scalar($value) || $value === null ? (string) $value : '') ?>
                                <?php endif ?>
                            </td>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
            </tbody>
        </table>
    </div>

    <?php if ($hasContextMenu): ?>
        <?= view('components/tables/context-menu', ['tableId' => $id, 'actions' => $contextActions]) ?>
    <?php endif ?>
</div>
