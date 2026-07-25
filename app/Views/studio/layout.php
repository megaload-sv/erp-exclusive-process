<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TraceOps Studio — herramientas visuales para explorar y construir sobre el Runtime">
    <title><?= esc($title ?? 'TraceOps Studio') ?> | <?= esc($appName ?? 'TraceOps ERP') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/design-system.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/studio.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/studio-explorer.css') ?>">
    <?= $this->renderSection('styles') ?>
</head>
<body class="studio-body">
<a class="to-sr-only" href="#studio-content">Saltar al contenido principal</a>
<div class="studio-shell">
    <aside class="studio-sidebar">
        <div class="studio-brand">
            <span class="studio-brand__mark">T</span>
            <div><strong>TraceOps Studio</strong><small><?= esc($runtimeVersion ?? 'Runtime') ?></small></div>
        </div>

        <p class="studio-navigation-label">Workspace</p>
        <nav class="studio-navigation" aria-label="Navegación de TraceOps Studio">
            <?php
                $items = [
                    ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'D', 'enabled' => false],
                    ['key' => 'explorer', 'label' => 'Explorer', 'icon' => 'E', 'enabled' => true],
                    ['key' => 'playground', 'label' => 'Playground', 'icon' => 'P', 'enabled' => false],
                    ['key' => 'inspector', 'label' => 'Inspector', 'icon' => 'I', 'enabled' => false],
                    ['key' => 'diagnostics', 'label' => 'Diagnostics', 'icon' => 'X', 'enabled' => false],
                    ['key' => 'ai', 'label' => 'AI', 'icon' => 'A', 'enabled' => false],
                ];
            ?>
            <?php foreach ($items as $item): ?>
                <?php $active = ($studioSection ?? 'explorer') === $item['key']; ?>
                <?php if ($item['enabled']): ?>
                    <a class="studio-nav-item <?= $active ? 'is-active' : '' ?>" href="<?= site_url('developer') ?>"><span class="studio-nav-icon"><?= esc($item['icon']) ?></span><span><?= esc($item['label']) ?></span></a>
                <?php else: ?>
                    <span class="studio-nav-item is-disabled" aria-disabled="true"><span class="studio-nav-icon"><?= esc($item['icon']) ?></span><span><?= esc($item['label']) ?></span><small>Próximamente</small></span>
                <?php endif ?>
            <?php endforeach ?>
        </nav>

        <div class="studio-sidebar__footer"><span>Studio v0.2 Alpha</span><a href="<?= site_url('/') ?>">Volver al ERP</a></div>
    </aside>

    <main id="studio-content" class="studio-main" tabindex="-1">
        <header class="studio-topbar">
            <div><p class="eyebrow">Developer Experience</p><h1><?= esc($title ?? 'TraceOps Studio') ?></h1></div>
            <div class="studio-topbar__actions">
                <?= view('components/ui/badge', ['label' => strtoupper(ENVIRONMENT), 'variant' => ENVIRONMENT === 'production' ? 'success' : 'warning']) ?>
                <?= view('components/ui/badge', ['label' => $runtimeVersion ?? 'Runtime', 'variant' => 'info']) ?>
            </div>
        </header>
        <div class="studio-workspace"><?= $this->renderSection('content') ?></div>
    </main>
</div>
<?= $this->renderSection('scripts') ?>
</body>
</html>
