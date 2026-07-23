<?php

/**
 * TraceOps switch component.
 *
 * @var string|null $name
 * @var string|null $label
 * @var string|null $id
 * @var string|null $description
 * @var bool|int|string|null $checked
 * @var bool|int|string|null $disabled
 */

$name = trim((string) ($name ?? ''));
$label = trim((string) ($label ?? ''));
$id = trim((string) ($id ?? $name));
$id = $id !== '' ? $id : $name;
$description = isset($description) && $description !== '' ? (string) $description : null;
$checked = filter_var($checked ?? false, FILTER_VALIDATE_BOOL);
$disabled = filter_var($disabled ?? false, FILTER_VALIDATE_BOOL);
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
