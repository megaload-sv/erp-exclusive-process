<?= $this->extend('studio/layout') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/developer-console.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content-panel developer-hero">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Runtime Explorer</p>
            <h2>Semantic component discovery</h2>
            <p>Busca, filtra y selecciona activos del Runtime sin inspeccionar directamente el código PHP.</p>
        </div>
        <?= view('components/ui/badge', [
            'label' => in_array(false, $runtimeHealth, true) ? 'Runtime degraded' : 'Runtime healthy',
            'variant' => in_array(false, $runtimeHealth, true) ? 'danger' : 'success',
        ]) ?>
    </div>

    <div class="developer-stats" aria-label="Métricas del Runtime">
        <?php foreach ($runtimeStats as $label => $value): ?>
            <article class="to-card developer-stat">
                <div class="to-card__body"><span><?= esc(ucfirst($label)) ?></span><strong><?= esc((string) $value) ?></strong></div>
            </article>
        <?php endforeach ?>
    </div>
</section>

<section class="studio-explorer" data-explorer>
    <aside class="studio-explorer__catalog" aria-label="Catálogo de componentes">
        <div class="studio-explorer__toolbar">
            <label class="developer-search"><span>Buscar</span><input type="search" data-explorer-search placeholder="button, clickable, boolean..." autocomplete="off"></label>
            <div class="studio-explorer__filters">
                <label>Category<select data-explorer-filter="category"><option value="">All</option><?php foreach ($filters['categories'] as $category): ?><option value="<?= esc(strtolower($category)) ?>"><?= esc($category) ?></option><?php endforeach ?></select></label>
                <label>Capability<select data-explorer-filter="capability"><option value="">All</option><?php foreach ($filters['capabilities'] as $capability): ?><option value="<?= esc(strtolower($capability)) ?>"><?= esc($capability) ?></option><?php endforeach ?></select></label>
                <label>Property type<select data-explorer-filter="propertyType"><option value="">All</option><?php foreach ($filters['types'] as $type): ?><option value="<?= esc(strtolower($type)) ?>"><?= esc($type) ?></option><?php endforeach ?></select></label>
            </div>
            <p data-explorer-status aria-live="polite"><?= count($components) ?> component(s).</p>
        </div>

        <div class="studio-explorer__list">
            <?php foreach ($components as $index => $component): ?>
                <?php $propertyTypes = array_map(static fn (array $property): string => strtolower((string) ($property['type'] ?? '')), $component['properties'] ?? []); ?>
                <button type="button" class="studio-explorer-item <?= $index === 0 ? 'is-active' : '' ?>" data-explorer-item data-component-index="<?= $index ?>" data-search="<?= esc($component['searchText']) ?>" data-category="<?= esc(strtolower((string) ($component['category'] ?? ''))) ?>" data-capabilities="<?= esc(strtolower(implode(' ', $component['capabilities'] ?? []))) ?>" data-property-types="<?= esc(implode(' ', $propertyTypes)) ?>">
                    <span class="studio-explorer-item__icon"><?= esc(strtoupper(substr($component['title'], 0, 1))) ?></span>
                    <span><strong><?= esc($component['title']) ?></strong><small><?= esc($component['identity']) ?></small></span>
                    <span class="studio-explorer-item__count"><?= count($component['properties'] ?? []) ?></span>
                </button>
            <?php endforeach ?>
        </div>
    </aside>

    <article class="studio-explorer__detail" data-explorer-detail>
        <?php foreach ($components as $index => $component): ?>
            <section class="studio-component-detail" data-component-detail="<?= $index ?>" <?= $index === 0 ? '' : 'hidden' ?>>
                <header class="studio-component-detail__header">
                    <div><p class="eyebrow"><?= esc($component['category'] ?? 'Component') ?></p><h2><?= esc($component['title']) ?></h2><p><?= esc($component['summary']) ?></p></div>
                    <?php if ($component['version']): ?><?= view('components/ui/badge', ['label' => 'Since ' . $component['version'], 'variant' => 'info']) ?><?php endif ?>
                </header>

                <div class="studio-component-detail__grid">
                    <section class="to-card"><header class="to-card__header"><h3>General</h3></header><div class="to-card__body"><dl class="developer-metadata">
                        <div><dt>Identity</dt><dd><code><?= esc($component['identity']) ?></code></dd></div><div><dt>Class</dt><dd><code><?= esc($component['class']) ?></code></dd></div><div><dt>View</dt><dd><code><?= esc($component['view']) ?></code></dd></div><div><dt>Slots</dt><dd><?= esc(implode(', ', $component['slots'] ?? [])) ?: 'None' ?></dd></div>
                    </dl></div></section>
                    <section class="to-card"><header class="to-card__header"><h3>Live preview</h3></header><div class="to-card__body studio-component-preview"><?php if (! empty($component['preview']['view'])): ?><?= view($component['preview']['view'], $component['preview']['data']) ?><?php else: ?><p>Preview not available.</p><?php endif ?></div></section>
                </div>

                <section class="to-card"><header class="to-card__header"><h3>Properties</h3></header><div class="to-card__body"><div class="developer-properties"><?php foreach (($component['properties'] ?? []) as $property): ?><div><strong><?= esc($property['label'] ?? $property['name']) ?></strong><code><?= esc($property['type']) ?></code><small><?= ! empty($property['required']) ? 'Required' : 'Optional' ?></small></div><?php endforeach ?></div></div></section>

                <section class="studio-component-detail__grid">
                    <section class="to-card"><header class="to-card__header"><h3>Capabilities</h3></header><div class="to-card__body"><div class="studio-chip-list"><?php foreach (($component['capabilities'] ?? []) as $capability): ?><span>✓ <?= esc($capability) ?></span><?php endforeach ?></div></div></section>
                    <section class="to-card"><header class="to-card__header"><h3>Relationships</h3></header><div class="to-card__body"><?php if (empty($component['relationships'])): ?><p>No explicit relationships registered.</p><?php else: ?><div class="developer-properties"><?php foreach ($component['relationships'] as $relationship): ?><div><strong><?= esc($relationship['source']) ?></strong><code><?= esc($relationship['type']) ?></code><small><?= esc($relationship['target']) ?></small></div><?php endforeach ?></div><?php endif ?></div></section>
                </section>

                <details class="developer-json"><summary>Inspect full descriptor</summary><pre><?= esc(json_encode($component, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) ?></pre></details>
            </section>
        <?php endforeach ?>
    </article>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(() => {
    const root = document.querySelector('[data-explorer]'); if (!root) return;
    const search = root.querySelector('[data-explorer-search]');
    const status = root.querySelector('[data-explorer-status]');
    const items = Array.from(root.querySelectorAll('[data-explorer-item]'));
    const details = Array.from(root.querySelectorAll('[data-component-detail]'));
    const filters = Array.from(root.querySelectorAll('[data-explorer-filter]'));
    const select = (item) => { items.forEach((candidate) => candidate.classList.toggle('is-active', candidate === item)); details.forEach((detail) => { detail.hidden = detail.dataset.componentDetail !== item.dataset.componentIndex; }); };
    const applyFilters = () => {
        const query = search.value.trim().toLowerCase();
        const values = Object.fromEntries(filters.map((filter) => [filter.dataset.explorerFilter, filter.value]));
        let visible = 0; let firstVisible = null;
        items.forEach((item) => {
            const matches = (!query || item.dataset.search.includes(query)) && (!values.category || item.dataset.category === values.category) && (!values.capability || item.dataset.capabilities.includes(values.capability)) && (!values.propertyType || item.dataset.propertyTypes.includes(values.propertyType));
            item.hidden = !matches; if (matches) { visible += 1; firstVisible ||= item; }
        });
        status.textContent = `${visible} component(s).`;
        const active = items.find((item) => item.classList.contains('is-active') && !item.hidden);
        if (!active && firstVisible) select(firstVisible);
        if (!firstVisible) details.forEach((detail) => { detail.hidden = true; });
    };
    items.forEach((item) => item.addEventListener('click', () => select(item)));
    search.addEventListener('input', applyFilters);
    filters.forEach((filter) => filter.addEventListener('change', applyFilters));
})();
</script>
<?= $this->endSection() ?>
