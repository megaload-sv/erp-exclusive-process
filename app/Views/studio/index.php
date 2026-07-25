<?= $this->extend('studio/layout') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/developer-console.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content-panel developer-hero" id="runtime-overview">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Runtime Explorer</p>
            <h2>Semantic Runtime Overview</h2>
            <p>Explora el Kernel, sus catálogos y sus componentes desde la primera herramienta visual de TraceOps Studio.</p>
        </div>
        <?= view('components/ui/badge', ['label' => 'Runtime healthy', 'variant' => 'success']) ?>
    </div>

    <div class="developer-toolbar">
        <label class="developer-search">
            <span>Buscar en el Explorer</span>
            <input id="runtime-search" type="search" placeholder="button, clickable, string..." autocomplete="off">
        </label>
        <p id="runtime-search-status" aria-live="polite">Mostrando todo el Runtime.</p>
    </div>

    <div class="developer-stats" aria-label="Métricas del Runtime">
        <?php foreach ($runtimeStats as $label => $value): ?>
            <article class="to-card developer-stat" data-runtime-searchable="<?= esc($label) ?> <?= esc((string) $value) ?>">
                <div class="to-card__body">
                    <span><?= esc(ucfirst($label)) ?></span>
                    <strong><?= esc((string) $value) ?></strong>
                </div>
            </article>
        <?php endforeach ?>
    </div>
</section>

<section class="developer-grid">
    <article class="to-card" data-runtime-searchable="runtime kernel health diagnostics">
        <header class="to-card__header">
            <p class="eyebrow">Diagnostics</p>
            <h2>Runtime Health</h2>
        </header>
        <div class="to-card__body">
            <ul class="check-list">
                <?php foreach ($runtimeHealth as $capability => $healthy): ?>
                    <li>
                        <span class="developer-health <?= $healthy ? 'is-healthy' : 'is-unhealthy' ?>"></span>
                        <?= esc($capability) ?>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </article>

    <article class="to-card" data-runtime-searchable="kernel <?= esc($kernelClass) ?>">
        <header class="to-card__header">
            <p class="eyebrow">Runtime Core</p>
            <h2>Kernel</h2>
        </header>
        <div class="to-card__body">
            <dl class="developer-metadata">
                <div><dt>Implementation</dt><dd><code><?= esc($kernelClass) ?></code></dd></div>
                <div><dt>Version</dt><dd><?= esc($runtimeVersion) ?></dd></div>
                <div><dt>Workspace</dt><dd>Explorer</dd></div>
            </dl>
        </div>
    </article>
</section>

<section class="content-panel" id="runtime-components">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Component Registry</p>
            <h2>Components</h2>
            <p>Catálogo visual generado a partir de los descriptores públicos del Runtime Kernel.</p>
        </div>
    </div>

    <div class="developer-card-grid">
        <?php foreach ($descriptors as $descriptor): ?>
            <?php $component = $descriptor->toArray(); ?>
            <article class="to-card" data-runtime-searchable="<?= esc(json_encode($component)) ?>">
                <header class="to-card__header">
                    <p class="eyebrow"><?= esc($component['category'] ?? 'Component') ?></p>
                    <h2><?= esc($component['displayName'] ?? $component['type']) ?></h2>
                </header>
                <div class="to-card__body">
                    <dl class="developer-metadata">
                        <div><dt>Type</dt><dd><code><?= esc($component['type']) ?></code></dd></div>
                        <div><dt>Capabilities</dt><dd><?= esc(implode(', ', $component['capabilities'] ?? [])) ?: 'None' ?></dd></div>
                        <div><dt>Slots</dt><dd><?= esc(implode(', ', $component['slots'] ?? [])) ?: 'None' ?></dd></div>
                    </dl>

                    <h3>Properties</h3>
                    <div class="developer-properties">
                        <?php foreach (($component['properties'] ?? []) as $property): ?>
                            <div>
                                <strong><?= esc($property['label'] ?? $property['name']) ?></strong>
                                <code><?= esc($property['type']) ?></code>
                                <small><?= ! empty($property['required']) ? 'Required' : 'Optional' ?></small>
                            </div>
                        <?php endforeach ?>
                    </div>

                    <details class="developer-json">
                        <summary>Ver descriptor</summary>
                        <pre><?= esc(json_encode($component, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) ?></pre>
                    </details>
                </div>
            </article>
        <?php endforeach ?>
    </div>
</section>

<section class="content-panel" id="runtime-catalogs">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Semantic Catalogs</p>
            <h2>Runtime Inventory</h2>
            <p>Resumen de tipos, capacidades, metadatos, relaciones y conocimiento disponibles.</p>
        </div>
    </div>

    <div class="developer-card-grid">
        <?php foreach ([
            'Capabilities' => $capabilityCatalog,
            'Types' => $typeCatalog,
            'Metadata' => $metadataCatalog,
            'Relationships' => $relationshipCatalog,
            'Knowledge' => $knowledgeCatalog,
        ] as $label => $catalog): ?>
            <article class="to-card" data-runtime-searchable="<?= esc($label . ' ' . json_encode($catalog)) ?>">
                <header class="to-card__header">
                    <p class="eyebrow">Catalog</p>
                    <h2><?= esc($label) ?></h2>
                </header>
                <div class="to-card__body">
                    <p><strong><?= count($catalog) ?></strong> registro(s) disponibles.</p>
                    <details class="developer-json">
                        <summary>Inspeccionar catálogo</summary>
                        <pre><?= esc(json_encode($catalog, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) ?></pre>
                    </details>
                </div>
            </article>
        <?php endforeach ?>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(() => {
    const input = document.getElementById('runtime-search');
    const status = document.getElementById('runtime-search-status');
    const items = Array.from(document.querySelectorAll('[data-runtime-searchable]'));

    if (!input || !status) return;

    input.addEventListener('input', () => {
        const query = input.value.trim().toLowerCase();
        let visible = 0;

        items.forEach((item) => {
            const matches = query === '' || (item.dataset.runtimeSearchable || '').toLowerCase().includes(query);
            item.hidden = !matches;
            if (matches) visible += 1;
        });

        status.textContent = query === ''
            ? 'Mostrando todo el Runtime.'
            : `${visible} resultado(s) para “${input.value.trim()}”.`;
    });
})();
</script>
<?= $this->endSection() ?>
