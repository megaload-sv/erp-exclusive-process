<?php

ob_start();
?>
<div class="to-form-grid">
    <div class="to-form-grid__col--8">
        <?= view('components/ui/input', [
            'name' => 'company_name',
            'label' => 'Razón social',
            'placeholder' => 'Ej. Megaload Logistics, S.A. de C.V.',
            'required' => true,
        ]) ?>
    </div>
    <div class="to-form-grid__col--4">
        <?= view('components/ui/input', [
            'name' => 'tax_id',
            'label' => 'NIT',
            'placeholder' => '0000-000000-000-0',
            'required' => true,
        ]) ?>
    </div>
    <div class="to-form-grid__col--6">
        <?= view('components/ui/select', [
            'name' => 'customer_type',
            'label' => 'Tipo de cliente',
            'placeholder' => 'Selecciona un tipo',
            'options' => [
                'corporate' => 'Corporativo',
                'retail' => 'Retail',
                'government' => 'Gobierno',
            ],
            'required' => true,
        ]) ?>
    </div>
    <div class="to-form-grid__col--6">
        <?= view('components/ui/input', [
            'name' => 'contact_email',
            'label' => 'Correo de contacto',
            'type' => 'email',
            'placeholder' => 'operaciones@empresa.com',
            'hint' => 'Se utilizará para notificaciones operativas.',
        ]) ?>
    </div>
</div>
<?php
$identityContent = ob_get_clean();

ob_start();
?>
<div class="to-form-grid">
    <div class="to-form-grid__col--6">
        <?= view('components/ui/select', [
            'name' => 'priority_level',
            'label' => 'Prioridad operativa',
            'placeholder' => 'Selecciona una prioridad',
            'options' => [
                'standard' => 'Estándar',
                'high' => 'Alta',
                'critical' => 'Crítica',
            ],
        ]) ?>
    </div>
    <div class="to-form-grid__col--6">
        <?= view('components/ui/input', [
            'name' => 'credit_days',
            'label' => 'Días de crédito',
            'type' => 'number',
            'value' => '30',
        ]) ?>
    </div>
    <div>
        <?= view('components/ui/textarea', [
            'name' => 'commercial_notes',
            'label' => 'Observaciones comerciales',
            'placeholder' => 'Agrega condiciones, restricciones o acuerdos relevantes.',
            'rows' => 4,
        ]) ?>
    </div>
</div>
<?php
$operationsContent = ob_get_clean();
?>
<form
    class="to-form"
    action="#"
    method="post"
    aria-label="Ejemplo de formulario empresarial"
    data-protect-submit
>
    <?= view('components/forms/section', [
        'title' => 'Identificación del cliente',
        'description' => 'Información legal y datos principales de contacto.',
        'content' => $identityContent,
        'legendId' => 'customer-identity-section',
    ]) ?>

    <?= view('components/forms/section', [
        'title' => 'Configuración operativa',
        'description' => 'Parámetros utilizados por los procesos comerciales y logísticos.',
        'content' => $operationsContent,
        'legendId' => 'customer-operations-section',
    ]) ?>

    <?= view('components/forms/actions', [
        'submitLabel' => 'Guardar cliente',
        'cancelLabel' => 'Cancelar',
        'note' => 'Los campos marcados con * son obligatorios.',
    ]) ?>
</form>
