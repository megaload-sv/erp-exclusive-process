<?php

/**
 * TraceOps select field component.
 *
 * @var string $name
 * @var string $label
 * @var array<int|string, string> $options
 * @var string|null $id
 * @var string|int|null $value
 * @var string|null $placeholder
 * @var string|null $hint
 * @var string|null $error
 * @var bool|null $required
 * @var bool|null $disabled
 */

$name = $name ?? '';
$label = $label ?? '';
$options = $options ?? [];
$id = $id ?? $name;
$value = $value ?? null;
$placeholder = $placeholder ?? null;
$hint = $hint ?? null;
$error = $error ?? null;
$required = $required ?? false;
$disabled = $disabled ?? false;
$descriptionId = $error !== null ? $id . '-error' : ($hint !== null ? $id . '-hint' : null);
$fieldClass = 'to-field' . ($error !== null ? ' to-field--error' : '');
?>
<div class="<?= esc($fieldClass) ?>">
    <label class="to-field__label" for="<?= esc($id) ?>">
        <?= esc($label) ?>
        <?php if ($required): ?><span class="to-field__required" aria-hidden="true">*</span><?php endif ?>
    </label>

    <select
        class="to-input to-select"
        id="<?= esc($id) ?>"
        name="<?= esc($name) ?>"
        <?= $descriptionId !== null ? 'aria-describedby="' . esc($descriptionId) . '"' : '' ?>
        <?= $error !== null ? 'aria-invalid="true"' : '' ?>
        <?= $required ? 'required' : '' ?>
        <?= $disabled ? 'disabled' : '' ?>
    >
        <?php if ($placeholder !== null): ?>
            <option value="" <?= $value === null || $value === '' ? 'selected' : '' ?> <?= $required ? 'disabled' : '' ?>><?= esc($placeholder) ?></option>
        <?php endif ?>

        <?php foreach ($options as $optionValue => $optionLabel): ?>
            <option value="<?= esc((string) $optionValue) ?>" <?= (string) $value === (string) $optionValue ? 'selected' : '' ?>>
                <?= esc($optionLabel) ?>
            </option>
        <?php endforeach ?>
    </select>

    <?php if ($error !== null): ?>
        <p class="to-field__message to-field__message--error" id="<?= esc($id) ?>-error"><?= esc($error) ?></p>
    <?php elseif ($hint !== null): ?>
        <p class="to-field__message" id="<?= esc($id) ?>-hint"><?= esc($hint) ?></p>
    <?php endif ?>
</div>
