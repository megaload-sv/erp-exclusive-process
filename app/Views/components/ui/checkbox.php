<?php

/**
 * TraceOps checkbox component.
 *
 * @var string $name
 * @var string $label
 * @var string|null $id
 * @var string|null $value
 * @var string|null $description
 * @var bool|null $checked
 * @var bool|null $disabled
 * @var bool|null $required
 */

$name = $name ?? '';
$label = $label ?? '';
$id = $id ?? $name;
$value = $value ?? '1';
$description = $description ?? null;
$checked = $checked ?? false;
$disabled = $disabled ?? false;
$required = $required ?? false;
$descriptionId = $description !== null ? $id . '-description' : null;
?>
<label class="to-choice <?= $disabled ? 'to-choice--disabled' : '' ?>" for="<?= esc($id) ?>">
    <input
        class="to-choice__control"
        id="<?= esc($id) ?>"
        name="<?= esc($name) ?>"
        type="checkbox"
        value="<?= esc($value) ?>"
        <?= $descriptionId !== null ? 'aria-describedby="' . esc($descriptionId) . '"' : '' ?>
        <?= $checked ? 'checked' : '' ?>
        <?= $required ? 'required' : '' ?>
        <?= $disabled ? 'disabled' : '' ?>
    >
    <span class="to-choice__content">
        <span class="to-choice__label">
            <?= esc($label) ?>
            <?php if ($required): ?><span class="to-field__required" aria-hidden="true">*</span><?php endif ?>
        </span>
        <?php if ($description !== null): ?>
            <span class="to-choice__description" id="<?= esc($descriptionId) ?>"><?= esc($description) ?></span>
        <?php endif ?>
    </span>
</label>
