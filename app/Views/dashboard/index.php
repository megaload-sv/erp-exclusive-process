<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<section class="hero-panel">
    <div>
        <p class="eyebrow">Application foundation</p>
        <h2><?= esc($appName) ?></h2>
        <p>Gestión Operativa con Trazabilidad Completa.</p>
    </div>
    <div class="version-card">
        <span>Current version</span>
        <strong><?= esc($appVersion) ?></strong>
    </div>
</section>

<section class="metrics-grid" aria-label="System information">
    <article class="metric-card"><span>Environment</span><strong><?= esc($environment) ?></strong></article>
    <article class="metric-card"><span>PHP</span><strong><?= esc($phpVersion) ?></strong></article>
    <article class="metric-card"><span>CodeIgniter</span><strong><?= esc($ciVersion) ?></strong></article>
    <article class="metric-card"><span>Database</span><strong class="status-<?= strtolower(str_replace(' ', '-', $dbStatus)) ?>"><?= esc($dbStatus) ?></strong></article>
</section>

<section class="content-panel">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Roadmap</p>
            <h2>Platform modules</h2>
        </div>
        <a href="<?= route_to('health') ?>" class="secondary-action">Health check</a>
    </div>

    <div class="module-grid">
        <?php foreach ($modules as $module): ?>
            <article class="module-card">
                <span class="module-icon"><?= esc(substr($module, 0, 1)) ?></span>
                <div>
                    <strong><?= esc($module) ?></strong>
                    <p>Scheduled for a future delivery.</p>
                </div>
                <span class="module-status">Planned</span>
            </article>
        <?php endforeach ?>
    </div>
</section>
<?= $this->endSection() ?>
