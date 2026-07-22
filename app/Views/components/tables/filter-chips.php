<?php

/**
 * TraceOps active table filters.
 *
 * @var array<int, array{key:string,label:string,value:string}> $filters
 * @var string|null $clearLabel
 */

$filters = $filters ?? [];
$clearLabel = $clearLabel ?? 'Limpiar filtros';
?>
<?php if ($filters !== []): ?>
    <div class="to-filter-chips" data-table-filter-chips aria-label="Filtros activos">
        <span class="to-filter-chips__label">Filtros activos:</span>

        <?php foreach ($filters as $filter): ?>
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
