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
?>
<div class="to-table-section">
    <?= view('components/tables/toolbar', [
        'searchName' => 'customer-search',
        'searchPlaceholder' => 'Buscar por cliente, país o código...',
        'primaryActionLabel' => 'Nuevo cliente',
        'primaryActionHref' => '#new-customer',
        'bulkActionLabel' => 'Acciones masivas',
        'resultCount' => count($customers),
    ]) ?>

    <?= view('components/tables/table', [
        'id' => 'customers-table',
        'caption' => 'Listado de clientes empresariales',
        'selectable' => true,
        'rowKey' => 'id',
        'columns' => [
            ['key' => 'id', 'label' => 'Código', 'sortable' => true],
            ['key' => 'customer', 'label' => 'Cliente', 'sortable' => true],
            ['key' => 'country', 'label' => 'País', 'sortable' => true],
            ['key' => 'status', 'label' => 'Estado', 'render' => $statusRenderer],
            ['key' => 'balance', 'label' => 'Balance', 'align' => 'end', 'sortable' => true],
            ['key' => 'updated_at', 'label' => 'Actualización', 'sortable' => true],
            ['key' => 'actions', 'label' => 'Acciones', 'align' => 'end', 'render' => $actionsRenderer],
        ],
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