<?php

/**
 * TraceOps radio group component.
 *
 * @var string|null $name
 * @var string|null $label
 * @var array<string,string>|null $options
 * @var string|int|float|null $selected
 * @var string|null $hint
 * @var string|null $error
 * @var bool|int|string|null $required
 * @var bool|int|string|null $disabled
 */

$name = trim((string) ($name ?? ''));
$label = trim((string) ($label ?? ''));
$rawOptions = is_array($options ?? null) ? $options : [];
$options = [];

foreach ($rawOptions as $value => $optionLabel) {
    if (is_array($optionLabel) || is_object($optionLabel)) {
        continue;
    }

    $options[(string) $value] = (string) $optionLabel;
}

$selected = isset($selected) ? (string) $selected : null;
$hint = isset($hint) && $hint !== '' ? (string) $hint : null;
$error = isset($error) && $error !== '' ? (string) $error : null;
$required = filter_var($required ?? false, FILTER_VALIDATE_BOOL);
$disabled = filter_var($disabled ?? false, FILTER_VALIDATE_BOOL);
$descriptionId = $error !== null
    ? $name . '-error'
    : ($hint !== null ? $name . '-hint' : null);
?>
<fieldset class="to-radio-group <?= $error !== null ? 'to-radio-group--error' : '' ?>" <?= $descriptionId !== null ? 'aria-describedby="' . esc($descriptionId) . '"' : '' ?>>
    <legend class="to-field__label">
        <?= esc($label) ?>
        <?php if ($required): ?><span class="to-field__required" aria-hidden="true">*</span><?php endif ?>
    </legend>

    <div class="to-radio-group__options">
        <?php foreach ($options as $value => $optionLabel): ?>
            <?php
            $suffix = preg_replace('/[^a-z0-9_-]+/i', '-', $value) ?: 'option';
            $id = ($name !== '' ? $name : 'radio') . '-' . trim($suffix, '-');
            ?>
            <label class="to-choice <?= $disabled ? 'to-choice--disabled' : '' ?>" for="<?= esc($id) ?>">
                <input
                    class="to-choice__control"
                    id="<?= esc($id) ?>"
                    name="<?= esc($name) ?>"
                    type="radio"
                    value="<?= esc($value) ?>"
                    <?= $selected !== null && $selected === $value ? 'checked' : '' ?>
                    <?= $required ? 'required' : '' ?>
                    <?= $disabled ? 'disabled' : '' ?>
                >
                <span class="to-choice__content"><span class="to-choice__label"><?= esc($optionLabel) ?></span></span>
            </label>
        <?php endforeach ?>
    </div>

    <?php if ($error !== null): ?>
        <p class="to-field__message to-field__message--error" id="<?= esc($name) ?>-error"><?= esc($error) ?></p>
    <?php elseif ($hint !== null): ?>
        <p class="to-field__message" id="<?= esc($name) ?>-hint"><?= esc($hint) ?></p>
    <?php endif ?>
</fieldset>
