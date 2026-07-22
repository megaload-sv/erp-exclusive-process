<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<section class="hero-panel">
    <div>
        <p class="eyebrow">Application Foundation</p>
        <h2>Bienvenido a <?= esc($appName) ?></h2>
        <p>La base empresarial de TraceOps ya está activa y preparada para recibir nuevos módulos.</p>
        <div class="hero-actions">
            <a href="<?= route_to('health') ?>" class="primary-action">Verificar sistema</a>
            <span class="hero-note">Operado por <?= esc($company) ?></span>
        </div>
    </div>
    <div class="version-card">
        <span>Versión actual</span>
        <strong><?= esc($appVersion) ?></strong>
        <small><?= esc($tagline) ?></small>
    </div>
</section>

<section class="metrics-grid" aria-label="Información del sistema">
    <article class="metric-card">
        <span>Entorno</span>
        <strong><?= esc(strtoupper($environment)) ?></strong>
        <small>Contexto de ejecución</small>
    </article>
    <article class="metric-card">
        <span>PHP</span>
        <strong><?= esc($phpVersion) ?></strong>
        <small>Motor de aplicación</small>
    </article>
    <article class="metric-card">
        <span>CodeIgniter</span>
        <strong><?= esc($ciVersion) ?></strong>
        <small>Framework principal</small>
    </article>
    <article class="metric-card">
        <span>Base de datos</span>
        <strong class="status-<?= strtolower(str_replace(' ', '-', $dbStatus)) ?>"><?= esc($dbStatus) ?></strong>
        <small>Estado de conectividad</small>
    </article>
</section>

<section class="content-panel">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Plataforma modular</p>
            <h2>Capacidades de TraceOps</h2>
            <p>Los módulos se publicarán progresivamente sobre esta fundación.</p>
        </div>
        <span class="release-badge">Milestone 1</span>
    </div>

    <div class="module-grid">
        <?php foreach ($modules as $module): ?>
            <article class="module-card <?= $module['enabled'] ? 'module-card-enabled' : '' ?>">
                <span class="module-icon"><?= esc(strtoupper(substr($module['label'], 0, 1))) ?></span>
                <div>
                    <strong><?= esc($module['label']) ?></strong>
                    <p><?= $module['enabled'] ? 'Disponible en esta versión.' : 'Preparado para una entrega futura.' ?></p>
                </div>
                <span class="module-status <?= $module['enabled'] ? 'module-status-enabled' : '' ?>">
                    <?= $module['enabled'] ? 'Activo' : 'Planeado' ?>
                </span>
            </article>
        <?php endforeach ?>
    </div>
</section>

<section class="foundation-grid">
    <article class="content-panel compact-panel">
        <p class="eyebrow">Estado de la fundación</p>
        <h2>Listo para crecer</h2>
        <ul class="check-list">
            <li>Configuración centralizada</li>
            <li>Navegación basada en módulos</li>
            <li>Health check operativo</li>
            <li>Contratos de permisos y auditoría</li>
        </ul>
    </article>
    <article class="content-panel compact-panel next-panel">
        <p class="eyebrow">Siguiente entrega</p>
        <h2>Enterprise Design System</h2>
        <p>Componentes reutilizables, identidad visual, accesibilidad y patrones consistentes para toda la plataforma.</p>
        <span class="release-badge">PR-003</span>
    </article>
</section>
<?= $this->endSection() ?>
