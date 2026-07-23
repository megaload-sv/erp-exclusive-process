<?php

use App\Libraries\TraceOps\UI\ComponentNormalizer;
use App\Libraries\TraceOps\UI\Components\ButtonComponent;

/**
 * TraceOps button component.
 *
 * @var string|null $label
 * @var string|null $variant primary|secondary|ghost|danger
 * @var string|null $href
 * @var string|null $type button|submit|reset
 * @var bool|null $disabled
 * @var string|null $loadingLabel
 * @var string|null $class
 * @var array<string, scalar|null>|null $attributes
 */

$viewData = get_defined_vars();
$config = ButtonComponent::normalize($viewData);

$label = $config['label'];
$variant = $config['variant'];
$href = $config['href'];
$type = $config['type'];
$disabled = $config['disabled'];
$loadingLabel = $config['loadingLabel'];
$classes = trim('to-btn to-btn--' . $variant . ' ' . $config['class']);
$attributes = ComponentNormalizer::attributes($viewData['attributes'] ?? []);
$attributeHtml = '';

foreach ($attributes as $attribute => $attributeValue) {
    $attributeHtml .= ' ' . esc($attribute) . '="' . esc((string) $attributeValue) . '"';
}

if ($loadingLabel !== null) {
    $attributeHtml .= ' data-loading-label="' . esc($loadingLabel) . '"';
}
?>
<?php if ($href !== null): ?>
    <a class="<?= esc($classes) ?>"
       href="<?= esc($href) ?>"
       <?= $disabled ? 'aria-disabled="true" tabindex="-1"' : '' ?><?= $attributeHtml ?>>
        <span class="to-btn__label"><?= esc($label) ?></span>
    </a>
<?php else: ?>
    <button class="<?= esc($classes) ?>" type="<?= esc($type) ?>" <?= $disabled ? 'disabled' : '' ?><?= $attributeHtml ?>>
        <span class="to-btn__spinner" aria-hidden="true"></span>
        <span class="to-btn__label"><?= esc($label) ?></span>
    </button>
<?php endif ?>
