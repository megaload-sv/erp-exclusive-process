<?php

/**
 * TraceOps row context menu.
 *
 * @var string|null $tableId
 * @var array<int, array<string, mixed>>|null $actions
 */

$tableId = isset($tableId) && is_string($tableId) && $tableId !== ''
    ? $tableId
    : 'enterprise-table';
$actions = isset($actions) && is_array($actions) ? $actions : [];
$allowedVariants = ['default', 'danger'];
?>
<div class="to-table-context-menu"
     data-table-context-menu
     data-table-target="<?= esc($tableId) ?>"
     role="menu"
     aria-label="Acciones del registro"
     hidden>
    <?php foreach ($actions as $action): ?>
        <?php
        if (! is_array($action)) {
            continue;
        }

        $key = trim((string) ($action['key'] ?? 'action'));
        $key = $key !== '' ? $key : 'action';
        $label = trim((string) ($action['label'] ?? $key));
        $label = $label !== '' ? $label : $key;
        $icon = (string) ($action['icon'] ?? '•');
        $requestedVariant = (string) ($action['variant'] ?? 'default');
        $variant = in_array($requestedVariant, $allowedVariants, true)
            ? $requestedVariant
            : 'default';
        $href = isset($action['href']) && is_scalar($action['href'])
            ? (string) $action['href']
            : null;
        $disabled = (bool) ($action['disabled'] ?? false);
        ?>
        <button type="button"
                class="to-table-context-menu__item<?= $variant === 'danger' ? ' is-danger' : '' ?>"
                role="menuitem"
                data-context-action="<?= esc($key) ?>"
                data-context-href="<?= esc($href ?? '') ?>"
                <?= $disabled ? 'disabled' : '' ?>>
            <span class="to-table-context-menu__icon" aria-hidden="true"><?= esc($icon) ?></span>
            <span><?= esc($label) ?></span>
        </button>
    <?php endforeach ?>
</div>
