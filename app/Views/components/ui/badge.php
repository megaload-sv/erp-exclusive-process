<?php

/**
 * TraceOps badge component.
 *
 * @var string|null $label
 * @var string|null $variant neutral|success|warning|danger|info
 */

$label = (string) ($label ?? 'Estado');
$requestedVariant = (string) ($variant ?? 'neutral');
$variant = in_array($requestedVariant, ['neutral', 'success', 'warning', 'danger', 'info'], true)
    ? $requestedVariant
    : 'neutral';
?>
<span class="to-badge to-badge--<?= esc($variant) ?>">
    <?= esc($label) ?>
</span>
