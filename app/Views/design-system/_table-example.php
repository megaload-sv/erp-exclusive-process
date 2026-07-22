<?php

$customers = [
    ['id' => 'CUS-001', 'customer' => 'Megaload Logistics', 'country' => 'El Salvador', 'status' => 'Activo', 'balance' => '$5,420.00', 'updated_at' => '22 jul 2026'],
    ['id' => 'CUS-002', 'customer' => 'Northline Apparel', 'country' => 'Estados Unidos', 'status' => 'Pendiente', 'balance' => '$1,280.50', 'updated_at' => '21 jul 2026'],
    ['id' => 'CUS-003', 'customer' => 'Pacífico Textiles', 'country' => 'Guatemala', 'status' => 'En revisión', 'balance' => '$890.00', 'updated_at' => '20 jul 2026'],
    ['id' => 'CUS-004', 'customer' => 'Atlas Manufacturing', 'country' => 'México', 'status' => 'Activo', 'balance' => '$9,110.75', 'updated_at' => '18 jul 2026'],
];

$statusRenderer = static function ($value): string {
    $variant = match ($value) {
        'Activo' => 'success',
        'Pendiente' => 'warning',
        default => 'info',
    };

    return view('components/ui/badge', ['label' => (string) $value, 'variant' => $variant]);
};

$actionsRenderer = static function ($value, array $row): string {
    return view('components/ui/button', [
        'label' => 'Ver detalle',
        'variant' => 'ghost',
        'href' => '#customer-' . $row['id'],
    ]);
};

$columns = [
    ['key' => 'id', 'label' => 'Código', 'sortable' => true, 'hideable' => false, 'width' => '8rem'],
    ['key' => 'customer', 'label' => 'Cliente', 'sortable' => true, 'width' => '15rem'],
    ['key' => 'country', 'label' => 'País', 'sortable' => true],
    ['key' => 'status', 'label' => 'Estado', 'render' => $statusRenderer],
    ['key' => 'balance', 'label' => 'Balance', 'align' => 'end', 'sortable' => true],
    ['key' => 'updated_at', 'label' => 'Actualización', 'sortable' => true],
    ['key' => 'actions', 'label' => 'Acciones', 'align' => 'end', 'render' => $actionsRenderer, 'hideable' => false],
];
?>
<div class="to-table-section">
    <?= view('components/tables/toolbar', [
        'searchName' => 'customer-search',
        'searchPlaceholder' => 'Buscar por cliente, país o código...',
        'primaryActionLabel' => 'Nuevo cliente',
        'primaryActionHref' => '#new-customer',
        'bulkActionLabel' => 'Acciones masivas',
        'resultCount' => count($customers),
        'tableId' => 'customers-table',
        'columns' => $columns,
    ]) ?>

    <?= view('components/tables/filter-chips', [
        'filters' => [
            ['key' => 'status', 'label' => 'Estado', 'value' => 'Activo'],
            ['key' => 'country', 'label' => 'País', 'value' => 'El Salvador'],
        ],
    ]) ?>

    <?= view('components/tables/table', [
        'id' => 'customers-table',
        'caption' => 'Listado de clientes empresariales',
        'selectable' => true,
        'rowKey' => 'id',
        'columns' => $columns,
        'rows' => $customers,
    ]) ?>

    <?= view('components/tables/pagination', [
        'currentPage' => 1,
        'totalPages' => 3,
        'from' => 1,
        'to' => 4,
        'total' => 12,
    ]) ?>
</div>

<div class="to-catalog-grid" style="margin-top: var(--to-ref-space-6)">
    <article class="to-card">
        <header class="to-card__header"><h3>Estado de carga</h3></header>
        <div class="to-card__body">
            <?= view('components/tables/table', [
                'id' => 'customers-loading-table',
                'caption' => 'Tabla cargando datos',
                'columns' => array_slice($columns, 0, 3),
                'rows' => [],
                'loading' => true,
                'skeletonRows' => 4,
            ]) ?>
        </div>
    </article>

    <article class="to-card">
        <header class="to-card__header"><h3>Estado de error</h3></header>
        <div class="to-card__body">
            <?= view('components/tables/table', [
                'id' => 'customers-error-table',
                'caption' => 'Tabla con error de carga',
                'columns' => array_slice($columns, 0, 3),
                'rows' => [],
                'errorTitle' => 'No fue posible cargar los clientes',
                'errorDescription' => 'Verifica tu conexión e intenta nuevamente.',
            ]) ?>
        </div>
    </article>
</div>
