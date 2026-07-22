<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/design-system-catalog.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content-panel">
    <div class="section-heading">
        <div>
            <p class="eyebrow">TraceOps Design Language</p>
            <h2>Catálogo de fundamentos y componentes</h2>
            <p>Referencia viva para construir interfaces consistentes, accesibles y mantenibles.</p>
        </div>
        <?= view('components/ui/badge', ['label' => 'PR-005.1', 'variant' => 'info']) ?>
    </div>
</section>

<section class="to-catalog-grid" aria-label="Fundamentos del sistema de diseño">
    <article class="to-card">
        <header class="to-card__header">
            <p class="eyebrow">Foundations</p>
            <h2>Tokens semánticos</h2>
        </header>
        <div class="to-card__body">
            <div class="to-token-list">
                <div><span class="to-token-swatch to-token-swatch--primary"></span><strong>Primary</strong><code>--to-sys-color-primary</code></div>
                <div><span class="to-token-swatch to-token-swatch--success"></span><strong>Success</strong><code>--to-sys-color-success</code></div>
                <div><span class="to-token-swatch to-token-swatch--warning"></span><strong>Warning</strong><code>--to-sys-color-warning</code></div>
                <div><span class="to-token-swatch to-token-swatch--danger"></span><strong>Danger</strong><code>--to-sys-color-danger</code></div>
                <div><span class="to-token-swatch to-token-swatch--surface"></span><strong>Surface</strong><code>--to-sys-color-surface</code></div>
            </div>
        </div>
    </article>

    <article class="to-card">
        <header class="to-card__header">
            <p class="eyebrow">Status</p>
            <h2>Entrega actual</h2>
        </header>
        <div class="to-card__body">
            <ul class="check-list">
                <li>Foundations y temas</li>
                <li>Button, Badge y Card</li>
                <li>Sistema empresarial de formularios</li>
                <li>Tabla semántica y responsiva</li>
                <li>Selección, ordenamiento y paginación</li>
                <li>Hardening y pruebas visuales de robustez</li>
            </ul>
        </div>
    </article>
</section>

<section class="content-panel">
    <div class="section-heading">
        <div><p class="eyebrow">Components</p><h2>Button</h2><p>Acciones principales, secundarias, discretas y destructivas.</p></div>
        <?= view('components/ui/badge', ['label' => 'Ready', 'variant' => 'success']) ?>
    </div>
    <div class="to-component-preview" aria-label="Variantes del componente Button">
        <?= view('components/ui/button', ['label' => 'Guardar cambios', 'variant' => 'primary']) ?>
        <?= view('components/ui/button', ['label' => 'Cancelar', 'variant' => 'secondary']) ?>
        <?= view('components/ui/button', ['label' => 'Ver detalles', 'variant' => 'ghost']) ?>
        <?= view('components/ui/button', ['label' => 'Eliminar', 'variant' => 'danger']) ?>
        <?= view('components/ui/button', ['label' => 'No disponible', 'variant' => 'primary', 'disabled' => true]) ?>
    </div>
</section>

<section class="content-panel">
    <div class="section-heading">
        <div><p class="eyebrow">Components</p><h2>Badge</h2><p>Estados compactos para procesos, registros y condiciones operativas.</p></div>
        <?= view('components/ui/badge', ['label' => 'Ready', 'variant' => 'success']) ?>
    </div>
    <div class="to-component-preview" aria-label="Variantes del componente Badge">
        <?= view('components/ui/badge', ['label' => 'Neutral', 'variant' => 'neutral']) ?>
        <?= view('components/ui/badge', ['label' => 'Activo', 'variant' => 'success']) ?>
        <?= view('components/ui/badge', ['label' => 'Pendiente', 'variant' => 'warning']) ?>
        <?= view('components/ui/badge', ['label' => 'Error', 'variant' => 'danger']) ?>
        <?= view('components/ui/badge', ['label' => 'Información', 'variant' => 'info']) ?>
    </div>
</section>

<section class="content-panel">
    <div class="section-heading">
        <div><p class="eyebrow">Enterprise Forms</p><h2>Input Field</h2><p>Unidad de captura con etiqueta, ayuda, validación y atributos accesibles.</p></div>
        <?= view('components/ui/badge', ['label' => 'Ready', 'variant' => 'success']) ?>
    </div>
    <div class="to-catalog-grid" aria-label="Estados del componente Input">
        <article class="to-card"><div class="to-card__body"><?= view('components/ui/input', ['name' => 'customer_name', 'label' => 'Nombre del cliente', 'placeholder' => 'Ej. Megaload Logistics', 'hint' => 'Utiliza el nombre comercial registrado.', 'required' => true]) ?></div></article>
        <article class="to-card"><div class="to-card__body"><?= view('components/ui/input', ['name' => 'customer_email', 'label' => 'Correo electrónico', 'type' => 'email', 'value' => 'correo-invalido', 'error' => 'Ingresa una dirección de correo válida.', 'required' => true]) ?></div></article>
        <article class="to-card"><div class="to-card__body"><?= view('components/ui/input', ['name' => 'system_code', 'label' => 'Código generado', 'value' => 'TO-CUS-0001', 'disabled' => true, 'hint' => 'Este valor es administrado por el sistema.']) ?></div></article>
    </div>
</section>

<section class="content-panel">
    <div class="section-heading">
        <div><p class="eyebrow">Enterprise Forms</p><h2>Textarea</h2><p>Captura de observaciones y contenido extenso con altura adaptable.</p></div>
        <?= view('components/ui/badge', ['label' => 'Ready', 'variant' => 'success']) ?>
    </div>
    <div class="to-catalog-grid" aria-label="Estados del componente Textarea">
        <article class="to-card"><div class="to-card__body"><?= view('components/ui/textarea', ['name' => 'operation_notes', 'label' => 'Observaciones operativas', 'placeholder' => 'Describe instrucciones, restricciones o condiciones especiales.', 'hint' => 'Máximo recomendado: 500 caracteres.', 'required' => true]) ?></div></article>
        <article class="to-card"><div class="to-card__body"><?= view('components/ui/textarea', ['name' => 'rejection_reason', 'label' => 'Motivo de rechazo', 'value' => 'Información incompleta.', 'error' => 'Explica el motivo con mayor detalle.', 'required' => true]) ?></div></article>
    </div>
</section>

<section class="content-panel">
    <div class="section-heading">
        <div><p class="eyebrow">Enterprise Forms</p><h2>Select</h2><p>Selección consistente de estados, categorías y entidades relacionadas.</p></div>
        <?= view('components/ui/badge', ['label' => 'Ready', 'variant' => 'success']) ?>
    </div>
    <div class="to-catalog-grid" aria-label="Estados del componente Select">
        <article class="to-card"><div class="to-card__body"><?= view('components/ui/select', ['name' => 'operation_status', 'label' => 'Estado de la operación', 'placeholder' => 'Selecciona un estado', 'options' => ['draft' => 'Borrador', 'pending' => 'Pendiente', 'approved' => 'Aprobada'], 'hint' => 'El estado controla las acciones disponibles.', 'required' => true]) ?></div></article>
        <article class="to-card"><div class="to-card__body"><?= view('components/ui/select', ['name' => 'priority', 'label' => 'Prioridad', 'placeholder' => 'Selecciona una prioridad', 'options' => ['low' => 'Baja', 'medium' => 'Media', 'high' => 'Alta'], 'error' => 'Debes seleccionar una prioridad.', 'required' => true]) ?></div></article>
    </div>
</section>

<section class="content-panel">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Enterprise Forms</p>
            <h2>Controles de decisión</h2>
            <p>Selecciones binarias y exclusivas para permisos, configuraciones y aprobaciones.</p>
        </div>
        <?= view('components/ui/badge', ['label' => 'Ready', 'variant' => 'success']) ?>
    </div>
    <div class="to-catalog-grid" aria-label="Checkbox, Radio Group y Switch">
        <article class="to-card"><header class="to-card__header"><h3>Checkbox</h3></header><div class="to-card__body"><div class="to-form"><?= view('components/ui/checkbox', ['name' => 'accept_terms', 'label' => 'Confirmar información', 'description' => 'Declaro que los datos fueron verificados.', 'checked' => true, 'required' => true]) ?><?= view('components/ui/checkbox', ['name' => 'locked_permission', 'label' => 'Permiso administrado', 'description' => 'Solo puede modificarse desde seguridad.', 'disabled' => true]) ?></div></div></article>
        <article class="to-card"><header class="to-card__header"><h3>Radio Group</h3></header><div class="to-card__body"><?= view('components/ui/radio-group', ['name' => 'approval_mode', 'label' => 'Modalidad de aprobación', 'options' => ['automatic' => 'Automática', 'manual' => 'Manual', 'supervisor' => 'Requiere supervisor'], 'selected' => 'manual', 'hint' => 'Selecciona una sola política para este proceso.', 'required' => true]) ?></div></article>
        <article class="to-card"><header class="to-card__header"><h3>Switch</h3></header><div class="to-card__body"><div class="to-form"><?= view('components/ui/switch', ['name' => 'notifications_enabled', 'label' => 'Notificaciones operativas', 'description' => 'Envía alertas cuando el proceso cambia de estado.', 'checked' => true]) ?><?= view('components/ui/switch', ['name' => 'audit_locked', 'label' => 'Auditoría obligatoria', 'description' => 'Configuración protegida por política corporativa.', 'checked' => true, 'disabled' => true]) ?></div></div></article>
    </div>
</section>

<section class="content-panel">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Quality Gate</p>
            <h2>Pruebas visuales de robustez</h2>
            <p>Configuraciones incompletas e inválidas que deben renderizarse con valores seguros, sin warnings ni errores fatales.</p>
        </div>
        <?= view('components/ui/badge', ['label' => 'Hardening', 'variant' => 'warning']) ?>
    </div>
    <?= view('design-system/_hardening-tests') ?>
</section>

<section class="content-panel">
    <div class="section-heading">
        <div><p class="eyebrow">Enterprise Forms</p><h2>Composición completa</h2><p>Secciones semánticas, distribución responsiva y acciones consistentes para formularios empresariales.</p></div>
        <?= view('components/ui/badge', ['label' => 'Ready', 'variant' => 'success']) ?>
    </div>
    <?= view('design-system/_form-example') ?>
</section>

<section class="content-panel">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Enterprise Tables</p>
            <h2>Data table foundation</h2>
            <p>Listado semántico y responsivo con selección, toolbar, encabezados ordenables, estados y paginación.</p>
        </div>
        <?= view('components/ui/badge', ['label' => 'Foundation', 'variant' => 'info']) ?>
    </div>
    <?= view('design-system/_table-example') ?>
</section>
<?= $this->endSection() ?>
