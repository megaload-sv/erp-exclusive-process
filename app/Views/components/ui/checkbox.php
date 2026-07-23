<?php

/**
 * TraceOps checkbox component.
 *
 * @var string|null $name
 * @var string|null $label
 * @var string|null $id
 * @var string|int|float|null $value
 * @var string|null $description
 * @var bool|int|string|null $checked
 * @var bool|int|string|null $disabled
 * @var bool|int|string|null $required
 */

$name = trim((string) ($name ?? ''));
$label = trim((string) ($label ?? ''));
$id = trim((string) ($id ?? $name));
$id = $id !== '' ? $id : $name;
$value = (string) ($value ?? '1');
$description = isset($description) && $description !== '' ? (string) $description : null;
$checked = filter_var($checked ?? false, FILTER_VALIDATE_BOOL);
$disabled = filter_var($disabled ?? false, FILTER_VALIDATE_BOOL);
$required = filter_var($required ?? false, FILTER_VALIDATE_BOOL);
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
