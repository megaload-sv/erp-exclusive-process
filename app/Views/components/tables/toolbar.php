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
 */

$searchName = $searchName ?? 'q';
$searchValue = $searchValue ?? '';
$searchPlaceholder = $searchPlaceholder ?? 'Buscar registros...';
$primaryActionLabel = $primaryActionLabel ?? null;
$primaryActionHref = $primaryActionHref ?? null;
$bulkActionLabel = $bulkActionLabel ?? 'Acciones masivas';
?>
<div class="to-table-toolbar" data-table-toolbar>
    <div class="to-table-toolbar__search">
        <label class="to-sr-only" for="<?= esc($searchName) ?>"><?= esc($searchPlaceholder) ?></label>
        <input id="<?= esc($searchName) ?>"
               class="to-input"
               type="search"
               name="<?= esc($searchName) ?>"
               value="<?= esc($searchValue) ?>"
               placeholder="<?= esc($searchPlaceholder) ?>"
               data-table-search>
    </div>

    <div class="to-table-toolbar__actions">
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
