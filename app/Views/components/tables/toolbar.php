<?php

/**
 * TraceOps table toolbar component.
 *
 * @var string|null $searchName
 * @var string|null $searchValue
 * @var string|null $searchPlaceholder
 * @var string|null $primaryActionLabel
 * @var string|null $primaryActionHref
 * @var string|null $bulkActionLabel
 * @var int|null $resultCount
 * @var string|null $tableId
 * @var array<int, array<string, mixed>> $columns
 */

$searchName = $searchName ?? 'q';
$searchValue = $searchValue ?? '';
$searchPlaceholder = $searchPlaceholder ?? 'Buscar registros...';
$primaryActionLabel = $primaryActionLabel ?? null;
$primaryActionHref = $primaryActionHref ?? null;
$bulkActionLabel = $bulkActionLabel ?? 'Acciones masivas';
$resultCount = $resultCount ?? null;
$tableId = $tableId ?? null;
$columns = $columns ?? [];
$searchId = 'table-search-' . preg_replace('/[^a-zA-Z0-9_-]/', '-', $searchName);
?>
<div class="to-table-toolbar" data-table-toolbar>
    <div class="to-table-toolbar__search-group">
        <div class="to-table-toolbar__search">
            <label class="to-sr-only" for="<?= esc($searchId) ?>"><?= esc($searchPlaceholder) ?></label>
            <input id="<?= esc($searchId) ?>"
                   class="to-input"
                   type="search"
                   name="<?= esc($searchName) ?>"
                   value="<?= esc($searchValue) ?>"
                   placeholder="<?= esc($searchPlaceholder) ?>"
                   autocomplete="off"
                   data-table-search>
        </div>
        <button type="button"
                class="to-btn to-btn--ghost to-table-toolbar__clear"
                data-table-clear-search>
            Limpiar
        </button>
        <?php if ($resultCount !== null): ?>
            <span class="to-table-toolbar__results" aria-live="polite">
                <strong data-table-result-count><?= esc((string) $resultCount) ?></strong> resultados
            </span>
        <?php endif ?>
    </div>

    <div class="to-table-toolbar__actions">
        <?php if ($tableId !== null && $columns !== []): ?>
            <?= view('components/tables/column-manager', [
                'tableId' => $tableId,
                'columns' => $columns,
            ]) ?>
        <?php endif ?>

        <button type="button" class="to-btn to-btn--secondary" data-table-bulk-action disabled>
            <span class="to-btn__label"><?= esc($bulkActionLabel) ?></span>
            <span class="to-table-toolbar__count" data-table-selection-count>0</span>
        </button>

        <?php if ($primaryActionLabel !== null): ?>
            <?= view('components/ui/button', [
                'label' => $primaryActionLabel,
                'variant' => 'primary',
                'href' => $primaryActionHref,
            ]) ?>
        <?php endif ?>
    </div>
</div>
