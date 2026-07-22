<?php

/**
 * TraceOps textarea field component.
 *
 * @var string|null $name
 * @var string|null $label
 * @var string|null $id
 * @var string|null $value
 * @var string|null $placeholder
 * @var string|null $hint
 * @var string|null $error
 * @var int|string|null $rows
 * @var bool|int|string|null $required
 * @var bool|int|string|null $disabled
 */

$name = trim((string) ($name ?? ''));
$label = trim((string) ($label ?? ''));
$id = trim((string) ($id ?? $name));
$id = $id !== '' ? $id : $name;
$value = (string) ($value ?? '');
$placeholder = isset($placeholder) && $placeholder !== '' ? (string) $placeholder : null;
$hint = isset($hint) && $hint !== '' ? (string) $hint : null;
$error = isset($error) && $error !== '' ? (string) $error : null;
$rows = max(2, (int) ($rows ?? 4));
$required = filter_var($required ?? false, FILTER_VALIDATE_BOOL);
$disabled = filter_var($disabled ?? false, FILTER_VALIDATE_BOOL);
$descriptionId = $error !== null
    ? $id . '-error'
    : ($hint !== null ? $id . '-hint' : null);
$fieldClass = 'to-field' . ($error !== null ? ' to-field--error' : '');
?>
<div class="<?= esc($fieldClass) ?>">
    <label class="to-field__label" for="<?= esc($id) ?>">
        <?= esc($label) ?>
        <?php if ($required): ?><span class="to-field__required" aria-hidden="true">*</span><?php endif ?>
    </label>

    <textarea
        class="to-input to-textarea"
        id="<?= esc($id) ?>"
        name="<?= esc($name) ?>"
        rows="<?= esc((string) $rows) ?>"
        <?= $placeholder !== null ? 'placeholder="' . esc($placeholder) . '"' : '' ?>
        <?= $descriptionId !== null ? 'aria-describedby="' . esc($descriptionId) . '"' : '' ?>
        <?= $error !== null ? 'aria-invalid="true"' : '' ?>
        <?= $required ? 'required' : '' ?>
        <?= $disabled ? 'disabled' : '' ?>
    ><?= esc($value) ?></textarea>

    <?php if ($error !== null): ?>
        <p class="to-field__message to-field__message--error" id="<?= esc($id) ?>-error"><?= esc($error) ?></p>
    <?php elseif ($hint !== null): ?>
        <p class="to-field__message" id="<?= esc($id) ?>-hint"><?= esc($hint) ?></p>
    <?php endif ?>
</div>
