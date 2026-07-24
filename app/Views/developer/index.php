<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/developer-console.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content-panel">
    <div class="section-heading">
        <div>
            <p class="eyebrow">TraceOps Semantic Runtime</p>
            <h2>Runtime Dashboard</h2>
            <p>Inspección visible de componentes, descriptores y comportamientos semánticos.</p>
        </div>
        <?= view('components/ui/badge', ['label' => $runtimeVersion, 'variant' => 'info']) ?>
    </div>

    <div class="developer-stats" aria-label="Métricas del Runtime">
        <?php foreach ($runtimeStats as $label => $value): ?>
            <article class="to-card developer-stat">
                <div class="to-card__body">
                    <span><?= esc(ucfirst($label)) ?></span>
                    <strong><?= esc((string) $value) ?></strong>
                </div>
            </article>
        <?php endforeach ?>
    </div>
</section>

<section class="developer-grid">
    <article class="to-card">
        <header class="to-card__header">
            <p class="eyebrow">Diagnostics</p>
            <h2>Runtime Health</h2>
        </header>
        <div class="to-card__body">
            <ul class="check-list">
                <?php foreach ($runtimeHealth as $capability => $healthy): ?>
                    <li><?= $healthy ? '✓' : '!' ?> <?= esc($capability) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    </article>

    <article class="to-card">
        <header class="to-card__header">
            <p class="eyebrow">Behavior Engine</p>
            <h2>Capability Explorer</h2>
        </header>
        <div class="to-card__body">
            <?php foreach ($capabilityCatalog as $capability): ?>
                <details class="developer-component">
                    <summary>
                        <strong><?= esc($capability['name']) ?></strong>
                        <small><?= count($capability['components']) ?> component(s)</small>
                    </summary>
                    <p><?= esc($capability['description'] ?? 'No description available.') ?></p>
                    <dl class="developer-metadata">
                        <div><dt>Contract</dt><dd><code><?= esc($capability['class']) ?></code></dd></div>
                        <div><dt>Consumers</dt><dd><?= esc(implode(', ', $capability['components'])) ?: 'None' ?></dd></div>
                    </dl>
                </details>
            <?php endforeach ?>
        </div>
    </article>
</section>

<section class="content-panel">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Registry</p>
            <h2>Component Explorer</h2>
            <p>Los comportamientos se resuelven desde el descriptor, sin comprobar implementaciones concretas.</p>
        </div>
    </div>

    <?php foreach ($descriptors as $descriptor): ?>
        <?php $metadata = $descriptor->toArray(); ?>
        <details class="developer-component" open>
            <summary>
                <strong><?= esc($metadata['displayName'] ?? $metadata['type']) ?></strong>
                <code><?= esc($metadata['type']) ?></code>
            </summary>
            <dl class="developer-metadata">
                <div><dt>Class</dt><dd><code><?= esc($metadata['class']) ?></code></dd></div>
                <div><dt>View</dt><dd><code><?= esc($metadata['view']) ?></code></dd></div>
                <div><dt>Category</dt><dd><?= esc($metadata['category'] ?? 'Uncategorized') ?></dd></div>
                <div><dt>Capabilities</dt><dd><?= esc(implode(', ', $metadata['capabilities'] ?? [])) ?: 'None' ?></dd></div>
                <div><dt>Slots</dt><dd><?= esc(implode(', ', $metadata['slots'] ?? [])) ?: 'None' ?></dd></div>
            </dl>

            <h3>Properties</h3>
            <div class="developer-properties">
                <?php foreach (($metadata['properties'] ?? []) as $property): ?>
                    <div>
                        <strong><?= esc($property['name']) ?></strong>
                        <code><?= esc($property['type']) ?></code>
                        <small><?= ! empty($property['required']) ? 'Required' : 'Optional' ?></small>
                    </div>
                <?php endforeach ?>
            </div>

            <h3>Raw descriptor</h3>
            <pre><?= esc(json_encode($metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) ?></pre>
        </details>
    <?php endforeach ?>
</section>
<?= $this->endSection() ?>
