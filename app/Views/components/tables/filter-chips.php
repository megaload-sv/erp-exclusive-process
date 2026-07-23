<?php

/**
 * TraceOps active table filters.
 *
 * @var array<int, array<string, mixed>>|null $filters
 * @var string|null $clearLabel
 */

$filters = isset($filters) && is_array($filters) ? $filters : [];
$clearLabel = isset($clearLabel) && is_string($clearLabel) && trim($clearLabel) !== ''
    ? $clearLabel
    : 'Limpiar filtros';
$normalizedFilters = [];

foreach ($filters as $filter) {
    if (! is_array($filter)) {
        continue;
    }

    $key = trim((string) ($filter['key'] ?? ''));
    $label = trim((string) ($filter['label'] ?? $key));
    $value = trim((string) ($filter['value'] ?? ''));

    if ($key === '' || $label === '') {
        continue;
    }

    $normalizedFilters[] = [
        'key' => $key,
        'label' => $label,
        'value' => $value,
    ];
}
?>
<?php if ($normalizedFilters !== []): ?>
    <div class="to-filter-chips" data-table-filter-chips aria-label="Filtros activos">
        <span class="to-filter-chips__label">Filtros activos:</span>

        <?php foreach ($normalizedFilters as $filter): ?>
            <button type="button"
                    class="to-filter-chip"
                    data-table-filter-remove="<?= esc($filter['key']) ?>"
                    aria-label="Quitar filtro <?= esc($filter['label']) ?>: <?= esc($filter['value']) ?>">
                <span><?= esc($filter['label']) ?>: <strong><?= esc($filter['value']) ?></strong></span>
                <span aria-hidden="true">×</span>
            </button>
        <?php endforeach ?>

        <button type="button" class="to-filter-chips__clear" data-table-filter-clear>
            <?= esc($clearLabel) ?>
        </button>
    </div>
<?php endif ?>
