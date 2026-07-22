<?php

/**
 * TraceOps button component.
 *
 * @var string $label
 * @var string|null $variant primary|secondary|ghost|danger
 * @var string|null $href
 * @var string|null $type
 * @var bool|null $disabled
 * @var string|null $loadingLabel
 * @var string|null $class
 * @var array<string, string>|null $attributes
 */

$variant = $variant ?? 'primary';
$href = $href ?? null;
$type = $type ?? 'button';
$disabled = $disabled ?? false;
$loadingLabel = $loadingLabel ?? null;
$extraClass = $class ?? '';
$attributes = $attributes ?? [];
$allowedVariants = ['primary', 'secondary', 'ghost', 'danger'];

if (! in_array($variant, $allowedVariants, true)) {
    $variant = 'primary';
}

$classes = trim('to-btn to-btn--' . $variant . ' ' . $extraClass);
$attributeHtml = '';

foreach ($attributes as $attribute => $attributeValue) {
    $attributeHtml .= ' ' . esc($attribute) . '="' . esc($attributeValue) . '"';
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
