<?php

/**
 * TraceOps button component.
 *
 * @var string $label
 * @var string|null $variant primary|secondary|ghost|danger
 * @var string|null $href
 * @var string|null $type
 * @var bool|null $disabled
 */

$variant = $variant ?? 'primary';
$href = $href ?? null;
$type = $type ?? 'button';
$disabled = $disabled ?? false;
$allowedVariants = ['primary', 'secondary', 'ghost', 'danger'];

if (! in_array($variant, $allowedVariants, true)) {
    $variant = 'primary';
}

$class = 'to-btn to-btn--' . $variant;
?>
<?php if ($href !== null): ?>
    <a class="<?= esc($class) ?>"
       href="<?= esc($href) ?>"
       <?= $disabled ? 'aria-disabled="true" tabindex="-1"' : '' ?>>
        <?= esc($label) ?>
    </a>
<?php else: ?>
    <button class="<?= esc($class) ?>" type="<?= esc($type) ?>" <?= $disabled ? 'disabled' : '' ?>>
        <?= esc($label) ?>
    </button>
<?php endif ?>
