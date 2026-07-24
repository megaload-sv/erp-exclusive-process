<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/developer-console.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content-panel developer-hero" id="runtime-overview">
    <div class="section-heading">
        <div>
            <p class="eyebrow">TraceOps Semantic Runtime</p>
            <h2>Developer Console</h2>
            <p>Inspecciona el Kernel, los registros, el grafo semántico y las consultas del Runtime desde una sola pantalla.</p>
        </div>
        <?= view('components/ui/badge', ['label' => $runtimeVersion, 'variant' => 'info']) ?>
    </div>

    <div class="developer-toolbar">
        <label class="developer-search">
            <span>Buscar en el Runtime</span>
            <input id="runtime-search" type="search" placeholder="component.button, clickable, string..." autocomplete="off">
        </label>
        <p id="runtime-search-status" aria-live="polite">Mostrando todo el Runtime.</p>
    </div>

    <nav class="developer-nav" aria-label="Secciones del Developer Console">
        <a href="#runtime-overview">Resumen</a>
        <a href="#runtime-kernel">Kernel</a>
        <a href="#runtime-query">Query Engine</a>
        <a href="#runtime-knowledge">Knowledge</a>
        <a href="#runtime-capabilities">Capabilities</a>
        <a href="#runtime-metadata">Metadata</a>
        <a href="#runtime-types">Types</a>
        <a href="#runtime-components">Components</a>
    </nav>

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

<section class="content-panel" id="runtime-kernel" data-runtime-searchable="runtime kernel contract implementation diagnostics health">
    <div class="section-heading"><div>
        <p class="eyebrow">Runtime Core</p><h2>TSR Kernel</h2>
        <p>Punto de entrada estable para todos los registros y el conocimiento semántico del Runtime.</p>
    </div></div>
    <dl class="developer-metadata">
        <div><dt>Contract</dt><dd><code>RuntimeKernelInterface</code></dd></div>
        <div><dt>Implementation</dt><dd><code><?= esc($kernelClass) ?></code></dd></div>
        <div><dt>Consumers</dt><dd>Developer Console, Studio, API, generators and AI</dd></div>
    </dl>
</section>

<section class="developer-grid">
    <article class="to-card" data-runtime-searchable="runtime health diagnostics <?= esc(implode(' ', array_keys($runtimeHealth))) ?>">
        <header class="to-card__header"><p class="eyebrow">Diagnostics</p><h2>Runtime Health</h2></header>
        <div class="to-card__body"><ul class="check-list">
            <?php foreach ($runtimeHealth as $capability => $healthy): ?>
                <li><span class="developer-health <?= $healthy ? 'is-healthy' : 'is-unhealthy' ?>"></span><?= esc($capability) ?></li>
            <?php endforeach ?>
        </ul></div>
    </article>
    <article class="to-card" data-runtime-searchable="knowledge registry semantic inventory <?= esc(implode(' ', array_keys($knowledgeSummary))) ?>">
        <header class="to-card__header"><p class="eyebrow">Knowledge Registry</p><h2>Semantic Inventory</h2></header>
        <div class="to-card__body">
            <p>Inventario unificado de todas las entidades conocidas por el Runtime.</p>
            <dl class="developer-metadata">
                <?php foreach ($knowledgeSummary as $kind => $count): ?>
                    <div><dt><?= esc(ucfirst($kind)) ?></dt><dd><?= esc((string) $count) ?></dd></div>
                <?php endforeach ?>
            </dl>
        </div>
    </article>
</section>

<section class="content-panel" id="runtime-query" data-runtime-searchable="semantic query engine filters components properties types capabilities">
    <div class="section-heading"><div>
        <p class="eyebrow">Semantic Discovery</p><h2>Query Engine</h2>
        <p>Consultas reales ejecutadas a través del contrato público del Runtime Kernel.</p>
    </div></div>
    <div class="developer-query-grid">
        <?php foreach ($queryExamples as $query): ?>
            <article class="to-card" data-runtime-searchable="<?= esc($query['label'] . ' ' . $query['expression'] . ' ' . json_encode($query['result'])) ?>">
                <header class="to-card__header">
                    <p class="eyebrow">RuntimeQuery</p>
                    <h2><?= esc($query['label']) ?></h2>
                </header>
                <div class="to-card__body">
                    <code class="developer-query-expression"><?= esc('$kernel->' . $query['expression']) ?></code>
                    <p><strong><?= count($query['result']) ?></strong> resultado(s)</p>
                    <pre><?= esc(json_encode($query['result'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) ?></pre>
                </div>
            </article>
        <?php endforeach ?>
    </div>
</section>

<section class="content-panel" id="runtime-knowledge">
    <div class="section-heading"><div>
        <p class="eyebrow">Semantic Knowledge Layer</p><h2>Knowledge Explorer</h2>
        <p>Una identidad consultable para componentes, propiedades, tipos, capacidades, metadatos y slots.</p>
    </div></div>
    <div class="developer-card-grid">
        <?php foreach ($knowledgeCatalog as $entity): ?>
            <article class="to-card" data-runtime-searchable="<?= esc($entity['kind'] . ' ' . $entity['name'] . ' ' . $entity['identity'] . ' ' . json_encode($entity['attributes'] ?? [])) ?>">
                <header class="to-card__header">
                    <p class="eyebrow"><?= esc($entity['kind']) ?></p>
                    <h2><?= esc($entity['name']) ?></h2>
                </header>
                <div class="to-card__body">
                    <dl class="developer-metadata">
                        <div><dt>Identity</dt><dd><code><?= esc($entity['identity']) ?></code></dd></div>
                    </dl>
                    <?php if (! empty($entity['attributes'])): ?>
                        <details class="developer-json"><summary>Ver atributos</summary><pre><?= esc(json_encode($entity['attributes'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) ?></pre></details>
                    <?php endif ?>
                </div>
            </article>
        <?php endforeach ?>
    </div>
</section>

<section class="developer-grid" id="runtime-capabilities">
    <article class="to-card" data-runtime-searchable="behavior capability engine <?= esc(json_encode($capabilityCatalog)) ?>">
        <header class="to-card__header"><p class="eyebrow">Behavior Engine</p><h2>Capability Explorer</h2></header>
        <div class="to-card__body">
            <?php foreach ($capabilityCatalog as $capability): ?>
                <details class="developer-component">
                    <summary><strong><?= esc($capability['name']) ?></strong><small><?= count($capability['components']) ?> component(s)</small></summary>
                    <p><?= esc($capability['description'] ?? 'No description available.') ?></p>
                    <dl class="developer-metadata">
                        <div><dt>Contract</dt><dd><code><?= esc($capability['class']) ?></code></dd></div>
                        <div><dt>Consumers</dt><dd><?= esc(implode(', ', $capability['components'])) ?: 'None' ?></dd></div>
                    </dl>
                </details>
            <?php endforeach ?>
        </div>
    </article>
    <article class="to-card" data-runtime-searchable="knowledge graph relationships <?= esc(json_encode($relationshipCatalog)) ?>">
        <header class="to-card__header"><p class="eyebrow">Knowledge Graph</p><h2>Relationship Explorer</h2></header>
        <div class="to-card__body">
            <div class="developer-properties">
                <?php foreach ($relationshipCatalog as $relationship): ?>
                    <div><strong><?= esc($relationship['source']) ?></strong><code><?= esc($relationship['type']) ?></code><small><?= esc($relationship['target']) ?></small></div>
                <?php endforeach ?>
            </div>
        </div>
    </article>
</section>

<section class="content-panel" id="runtime-metadata">
    <div class="section-heading"><div>
        <p class="eyebrow">Knowledge Layer</p><h2>Metadata Explorer</h2>
        <p>Metadatos reutilizables para componentes, propiedades, tipos y futuras entidades del Runtime.</p>
    </div></div>
    <div class="developer-card-grid">
        <?php foreach ($metadataCatalog as $identity => $metadata): ?>
            <article class="to-card" data-runtime-searchable="<?= esc($identity . ' ' . json_encode($metadata)) ?>">
                <header class="to-card__header"><p class="eyebrow"><?= esc($metadata['category'] ?? $metadata['group'] ?? 'metadata') ?></p><h2><?= esc($metadata['title'] ?? $identity) ?></h2></header>
                <div class="to-card__body">
                    <p><?= esc($metadata['summary'] ?? $metadata['description'] ?? 'Semantic metadata entry.') ?></p>
                    <dl class="developer-metadata">
                        <div><dt>Identity</dt><dd><code><?= esc($identity) ?></code></dd></div>
                        <?php if (isset($metadata['since'])): ?><div><dt>Since</dt><dd><?= esc($metadata['since']) ?></dd></div><?php endif ?>
                        <?php if (isset($metadata['tags'])): ?><div><dt>Tags</dt><dd><?= esc(implode(', ', $metadata['tags'])) ?></dd></div><?php endif ?>
                    </dl>
                    <details class="developer-json"><summary>Ver JSON</summary><pre><?= esc(json_encode($metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) ?></pre></details>
                </div>
            </article>
        <?php endforeach ?>
    </div>
</section>

<section class="content-panel" id="runtime-types">
    <div class="section-heading"><div>
        <p class="eyebrow">Type Engine</p><h2>Type Explorer</h2>
        <p>Catálogo de significado, representación PHP y componente de entrada recomendado.</p>
    </div></div>
    <div class="developer-card-grid">
        <?php foreach ($typeCatalog as $type): ?>
            <article class="to-card" data-runtime-searchable="<?= esc(json_encode($type)) ?>">
                <header class="to-card__header"><p class="eyebrow"><?= esc($type['phpType']) ?></p><h2><?= esc($type['name']) ?></h2></header>
                <div class="to-card__body">
                    <p><?= esc($type['description'] ?? 'No description available.') ?></p>
                    <dl class="developer-metadata"><div><dt>Input</dt><dd><code><?= esc($type['input'] ?? 'none') ?></code></dd></div><?php if (isset($type['format'])): ?><div><dt>Format</dt><dd><?= esc($type['format']) ?></dd></div><?php endif ?></dl>
                    <details class="developer-json"><summary>Ver descriptor</summary><pre><?= esc(json_encode($type, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) ?></pre></details>
                </div>
            </article>
        <?php endforeach ?>
    </div>
</section>

<section class="content-panel" id="runtime-components">
    <div class="section-heading"><div>
        <p class="eyebrow">Registry</p><h2>Component Explorer</h2>
        <p>Los descriptores exponen propiedades con tipos y metadatos semánticos estables.</p>
    </div></div>
    <?php foreach ($descriptors as $descriptor): ?>
        <?php $metadata = $descriptor->toArray(); ?>
        <details class="developer-component" open data-runtime-searchable="<?= esc(json_encode($metadata)) ?>">
            <summary><strong><?= esc($metadata['displayName'] ?? $metadata['type']) ?></strong><code><?= esc($metadata['type']) ?></code></summary>
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
                    <div><strong><?= esc($property['label'] ?? $property['name']) ?></strong><code><?= esc($property['type']) ?></code><small><?= ! empty($property['required']) ? 'Required' : 'Optional' ?></small><?php if (! empty($property['metadata']['group'])): ?><small><?= esc($property['metadata']['group']) ?></small><?php endif ?></div>
                <?php endforeach ?>
            </div>
            <details class="developer-json"><summary>Ver descriptor completo</summary><pre><?= esc(json_encode($metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) ?></pre></details>
        </details>
    <?php endforeach ?>
</section>

<script>
(() => {
    const input = document.getElementById('runtime-search');
    const status = document.getElementById('runtime-search-status');
    const items = Array.from(document.querySelectorAll('[data-runtime-searchable]'));

    input?.addEventListener('input', () => {
        const query = input.value.trim().toLowerCase();
        let visible = 0;

        items.forEach((item) => {
            const matches = query === '' || (item.dataset.runtimeSearchable || '').toLowerCase().includes(query);
            item.hidden = !matches;
            if (matches) visible += 1;
        });

        status.textContent = query === ''
            ? 'Mostrando todo el Runtime.'
            : `${visible} elemento(s) encontrados para “${input.value.trim()}”.`;
    });
})();
</script>
<?= $this->endSection() ?>
