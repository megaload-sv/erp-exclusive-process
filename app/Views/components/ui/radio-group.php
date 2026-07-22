<?php

/**
 * TraceOps radio group component.
 *
 * @var string $name
 * @var string $label
 * @var array<string,string> $options
 * @var string|null $selected
 * @var string|null $hint
 * @var string|null $error
 * @var bool|null $required
 * @var bool|null $disabled
 */

$name = $name ?? '';
$label = $label ?? '';
$options = $options ?? [];
$selected = $selected ?? null;
$hint = $hint ?? null;
$error = $error ?? null;
$required = $required ?? false;
$disabled = $disabled ?? false;
$descriptionId = $error !== null ? $name . '-error' : ($hint !== null ? $name . '-hint' : null);
?>
<fieldset class="to-radio-group <?= $error !== null ? 'to-radio-group--error' : '' ?>" <?= $descriptionId !== null ? 'aria-describedby="' . esc($descriptionId) . '"' : '' ?>>
    <legend class="to-field__label">
        <?= esc($label) ?>
        <?php if ($required): ?><span class="to-field__required" aria-hidden="true">*</span><?php endif ?>
    </legend>

    <div class="to-radio-group__options">
        <?php foreach ($options as $value => $optionLabel): ?>
            <?php $id = $name . '-' . preg_replace('/[^a-z0-9_-]+/i', '-', (string) $value); ?>
            <label class="to-choice <?= $disabled ? 'to-choice--disabled' : '' ?>" for="<?= esc($id) ?>">
                <input
                    class="to-choice__control"
                    id="<?= esc($id) ?>"
                    name="<?= esc($name) ?>"
                    type="radio"
                    value="<?= esc((string) $value) ?>"
                    <?= (string) $selected === (string) $value ? 'checked' : '' ?>
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
