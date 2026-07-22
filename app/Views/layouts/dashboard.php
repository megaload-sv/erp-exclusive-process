<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TraceOps ERP — Gestión operativa con trazabilidad completa">
    <title><?= esc($title ?? 'Dashboard') ?> | <?= esc($appName ?? 'TraceOps ERP') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/design-system.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/form-system.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/form-feedback.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    <?= $this->renderSection('styles') ?>
</head>
<body>
<a class="to-sr-only" href="#main-content">Saltar al contenido principal</a>
<div class="app-shell">
    <aside class="sidebar">
        <div class="brand">
            <span class="brand-mark">T</span>
            <div>
                <strong><?= esc($appName ?? 'TraceOps ERP') ?></strong>
                <small><?= esc($company ?? 'Grupo Megaload') ?></small>
            </div>
        </div>

        <p class="navigation-label">Workspace</p>
        <nav class="navigation" aria-label="Navegación principal">
            <?php foreach (($moduleRegistry ?? []) as $key => $module): ?>
                <?php
                    $isDashboard = $key === 'dashboard';
                    $classes = ['nav-item'];

                    if ($isDashboard) {
                        $classes[] = 'active';
                    }

                    if (! $module['enabled']) {
                        $classes[] = 'disabled';
                    }
                ?>

                <?php if ($module['enabled']): ?>
                    <a class="<?= esc(implode(' ', $classes)) ?>" href="<?= site_url(ltrim($module['route'], '/')) ?>">
                        <span>
                            <span class="nav-icon"><?= esc(strtoupper(substr($module['label'], 0, 1))) ?></span>
                            <?= esc($module['label']) ?>
                        </span>
                        <?php if ($isDashboard): ?><small>Inicio</small><?php endif ?>
                    </a>
                <?php else: ?>
                    <span class="<?= esc(implode(' ', $classes)) ?>" aria-disabled="true">
                        <span>
                            <span class="nav-icon"><?= esc(strtoupper(substr($module['label'], 0, 1))) ?></span>
                            <?= esc($module['label']) ?>
                        </span>
                        <small>Próximamente</small>
                    </span>
                <?php endif ?>
            <?php endforeach ?>
        </nav>

        <div class="sidebar-footer">
            <span>Versión <?= esc($appVersion ?? '0.1.0-alpha') ?></span>
            <small><?= esc($tagline ?? 'Engineering Beyond Code') ?></small>
        </div>
    </aside>

    <main id="main-content" class="main-content" tabindex="-1">
        <header class="topbar">
            <div>
                <p class="eyebrow">Plataforma de gestión</p>
                <h1><?= esc($title ?? 'Dashboard') ?></h1>
            </div>
            <div class="topbar-actions">
                <?= view('components/ui/badge', [
                    'label' => strtoupper(ENVIRONMENT),
                    'variant' => ENVIRONMENT === 'production' ? 'success' : 'warning',
                ]) ?>
                <div class="user-chip" aria-label="Usuario actual">
                    <span class="user-avatar">JL</span>
                    <span><strong>José Luis</strong><small>Administrador</small></span>
                </div>
            </div>
        </header>

        <?= $this->renderSection('content') ?>
    </main>
</div>
<script src="<?= base_url('assets/js/form-system.js') ?>" defer></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
