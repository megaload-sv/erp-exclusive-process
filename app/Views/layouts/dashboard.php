<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TraceOps ERP — Operational Process Management">
    <title><?= esc($title ?? 'Dashboard') ?> | <?= esc(env('app.name', 'TraceOps ERP')) ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <div class="brand">
            <span class="brand-mark">T</span>
            <div>
                <strong>TraceOps ERP</strong>
                <small>Operational Process Management</small>
            </div>
        </div>

        <nav class="navigation" aria-label="Main navigation">
            <a class="nav-item active" href="<?= route_to('dashboard') ?>">Dashboard</a>
            <?php foreach (['CRM', 'Customers', 'Operations', 'Workflow', 'Inventory', 'Accounting', 'Administration'] as $item): ?>
                <span class="nav-item disabled" aria-disabled="true"><?= esc($item) ?><small>Coming soon</small></span>
            <?php endforeach ?>
        </nav>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <div>
                <p class="eyebrow">Management platform</p>
                <h1><?= esc($title ?? 'Dashboard') ?></h1>
            </div>
            <span class="environment-badge"><?= esc(strtoupper(ENVIRONMENT)) ?></span>
        </header>

        <?= $this->renderSection('content') ?>
    </main>
</div>
</body>
</html>
