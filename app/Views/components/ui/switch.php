<?php

/**
 * TraceOps switch component.
 *
 * @var string $name
 * @var string $label
 * @var string|null $id
 * @var string|null $description
 * @var bool|null $checked
 * @var bool|null $disabled
 */

$name = $name ?? '';
$label = $label ?? '';
$id = $id ?? $name;
$description = $description ?? null;
$checked = $checked ?? false;
$disabled = $disabled ?? false;
$descriptionId = $description !== null ? $id . '-description' : null;
?>
<label class="to-switch <?= $disabled ? 'to-switch--disabled' : '' ?>" for="<?= esc($id) ?>">
    <span class="to-switch__content">
        <span class="to-switch__label"><?= esc($label) ?></span>
        <?php if ($description !== null): ?>
            <span class="to-switch__description" id="<?= esc($descriptionId) ?>"><?= esc($description) ?></span>
        <?php endif ?>
    </span>
    <input
        class="to-switch__control"
        id="<?= esc($id) ?>"
        name="<?= esc($name) ?>"
        type="checkbox"
        role="switch"
        value="1"
        <?= $descriptionId !== null ? 'aria-describedby="' . esc($descriptionId) . '"' : '' ?>
        <?= $checked ? 'checked' : '' ?>
        <?= $disabled ? 'disabled' : '' ?>
    >
    <span class="to-switch__track" aria-hidden="true"><span class="to-switch__thumb"></span></span>
</label>
