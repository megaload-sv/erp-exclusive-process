<?php

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

$label = (string) ($label ?? 'Acción');
$requestedVariant = (string) ($variant ?? 'primary');
$variant = in_array($requestedVariant, ['primary', 'secondary', 'ghost', 'danger'], true)
    ? $requestedVariant
    : 'primary';
$href = isset($href) && trim((string) $href) !== '' ? (string) $href : null;
$requestedType = (string) ($type ?? 'button');
$type = in_array($requestedType, ['button', 'submit', 'reset'], true) ? $requestedType : 'button';
$disabled = (bool) ($disabled ?? false);
$loadingLabel = isset($loadingLabel) && trim((string) $loadingLabel) !== '' ? (string) $loadingLabel : null;
$extraClass = trim((string) ($class ?? ''));
$attributes = is_array($attributes ?? null) ? $attributes : [];
$classes = trim('to-btn to-btn--' . $variant . ' ' . $extraClass);
$attributeHtml = '';

foreach ($attributes as $attribute => $attributeValue) {
    $attribute = (string) $attribute;

    if (! preg_match('/^[a-zA-Z_:][a-zA-Z0-9:._-]*$/', $attribute) || ! is_scalar($attributeValue)) {
        continue;
    }

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
