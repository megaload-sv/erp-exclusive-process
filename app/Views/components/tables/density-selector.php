<?php

/**
 * TraceOps table density selector.
 *
 * @var string|null $tableId
 * @var string|null $defaultDensity
 */

$tableId = isset($tableId) && is_string($tableId) && $tableId !== ''
    ? $tableId
    : 'enterprise-table';
$allowedDensities = ['compact', 'comfortable', 'spacious'];
$requestedDensity = isset($defaultDensity) && is_string($defaultDensity)
    ? $defaultDensity
    : 'comfortable';
$defaultDensity = in_array($requestedDensity, $allowedDensities, true)
    ? $requestedDensity
    : 'comfortable';
$options = [
    'compact' => [
        'label' => 'Compacta',
        'description' => 'Más registros visibles',
    ],
    'comfortable' => [
        'label' => 'Cómoda',
        'description' => 'Equilibrio recomendado',
    ],
    'spacious' => [
        'label' => 'Espaciosa',
        'description' => 'Mayor separación visual',
    ],
];
?>
<details class="to-density-selector"
         data-density-selector
         data-table-target="<?= esc($tableId) ?>">
    <summary class="to-btn to-btn--secondary"
             aria-label="Cambiar densidad de la tabla">
        <span>Densidad</span>
        <span class="to-density-selector__current" data-density-label>
            <?= esc($options[$defaultDensity]['label']) ?>
        </span>
    </summary>

    <div class="to-density-selector__panel">
        <header class="to-density-selector__header">
            <strong>Densidad de filas</strong>
            <span>Elige cuánto espacio utiliza cada registro.</span>
        </header>

        <div class="to-density-selector__options" role="radiogroup" aria-label="Densidad de la tabla">
            <?php foreach ($options as $value => $option): ?>
                <label class="to-density-selector__option">
                    <input type="radio"
                           name="density-<?= esc($tableId) ?>"
                           value="<?= esc($value) ?>"
                           data-density-option
                           <?= $value === $defaultDensity ? 'checked' : '' ?>>
                    <span>
                        <strong><?= esc((string) ($option['label'] ?? $value)) ?></strong>
                        <small><?= esc((string) ($option['description'] ?? '')) ?></small>
                    </span>
                </label>
            <?php endforeach ?>
        </div>

        <footer class="to-density-selector__footer">
            <button type="button" class="to-btn to-btn--ghost" data-density-reset>
                Restablecer
            </button>
        </footer>
    </div>
</details>
