<?php

/**
 * TraceOps badge component.
 *
 * @var string $label
 * @var string|null $variant neutral|success|warning|danger|info
 */

$variant = $variant ?? 'neutral';
$allowedVariants = ['neutral', 'success', 'warning', 'danger', 'info'];

if (! in_array($variant, $allowedVariants, true)) {
    $variant = 'neutral';
}
?>
<span class="to-badge to-badge--<?= esc($variant) ?>">
    <?= esc($label) ?>
</span>
