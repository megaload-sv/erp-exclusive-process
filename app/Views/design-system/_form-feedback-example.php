<div class="to-form">
    <?= view('components/forms/validation-summary', [
        'id' => 'feedback-validation-summary',
        'errors' => [
            'feedback-customer-name' => 'El nombre del cliente es obligatorio.',
            'feedback-customer-email' => 'Ingresa una dirección de correo válida.',
        ],
    ]) ?>

    <form class="to-form" action="<?= current_url() ?>" method="get" data-protect-submit>
        <div class="to-form-grid">
            <div class="to-form-grid__col--6">
                <?= view('components/ui/input', [
                    'id' => 'feedback-customer-name',
                    'name' => 'feedback_customer_name',
                    'label' => 'Nombre del cliente',
                    'error' => 'El nombre del cliente es obligatorio.',
                    'required' => true,
                ]) ?>
            </div>
            <div class="to-form-grid__col--6">
                <?= view('components/ui/input', [
                    'id' => 'feedback-customer-email',
                    'name' => 'feedback_customer_email',
                    'label' => 'Correo electrónico',
                    'type' => 'email',
                    'value' => 'correo-invalido',
                    'error' => 'Ingresa una dirección de correo válida.',
                    'required' => true,
                ]) ?>
            </div>
        </div>

        <?= view('components/forms/actions', [
            'submitLabel' => 'Guardar demostración',
            'submitLoadingLabel' => 'Guardando demostración...',
            'note' => 'El botón se bloquea automáticamente después de un envío válido.',
        ]) ?>
    </form>
</div>
