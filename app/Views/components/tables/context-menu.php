<?php

/**
 * TraceOps row context menu.
 *
 * @var string $tableId
 * @var array<int, array<string, mixed>> $actions
 */

$tableId = $tableId ?? 'enterprise-table';
$actions = $actions ?? [];
?>
<div class="to-table-context-menu"
     data-table-context-menu
     data-table-target="<?= esc($tableId) ?>"
     role="menu"
     aria-label="Acciones del registro"
     hidden>
    <?php foreach ($actions as $action): ?>
        <?php
        $key = (string) ($action['key'] ?? 'action');
        $label = (string) ($action['label'] ?? $key);
        $icon = (string) ($action['icon'] ?? '•');
        $variant = in_array(($action['variant'] ?? 'default'), ['default', 'danger'], true)
            ? (string) $action['variant']
            : 'default';
        $href = isset($action['href']) ? (string) $action['href'] : null;
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
