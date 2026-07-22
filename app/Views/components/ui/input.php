<?php

/**
 * TraceOps input field component.
 *
 * @var string|null $name
 * @var string|null $label
 * @var string|null $id
 * @var string|null $type
 * @var string|null $value
 * @var string|null $placeholder
 * @var string|null $hint
 * @var string|null $error
 * @var bool|null $required
 * @var bool|null $disabled
 */

$name = trim((string) ($name ?? 'field'));
$name = $name !== '' ? $name : 'field';
$label = (string) ($label ?? 'Campo');
$id = trim((string) ($id ?? $name));
$id = $id !== '' ? $id : $name;
$requestedType = (string) ($type ?? 'text');
$allowedTypes = ['text', 'email', 'password', 'number', 'search', 'tel', 'url', 'date', 'time', 'datetime-local', 'month', 'week'];
$type = in_array($requestedType, $allowedTypes, true) ? $requestedType : 'text';
$value = is_scalar($value ?? '') ? (string) ($value ?? '') : '';
$placeholder = isset($placeholder) && trim((string) $placeholder) !== '' ? (string) $placeholder : null;
$hint = isset($hint) && trim((string) $hint) !== '' ? (string) $hint : null;
$error = isset($error) && trim((string) $error) !== '' ? (string) $error : null;
$required = (bool) ($required ?? false);
$disabled = (bool) ($disabled ?? false);
$descriptionId = $error !== null ? $id . '-error' : ($hint !== null ? $id . '-hint' : null);
$fieldClass = 'to-field' . ($error !== null ? ' to-field--error' : '');
?>
<div class="<?= esc($fieldClass) ?>">
    <label class="to-field__label" for="<?= esc($id) ?>">
        <?= esc($label) ?>
        <?php if ($required): ?><span class="to-field__required" aria-hidden="true">*</span><?php endif ?>
    </label>

    <input
        class="to-input"
        id="<?= esc($id) ?>"
        name="<?= esc($name) ?>"
        type="<?= esc($type) ?>"
        value="<?= esc($value) ?>"
        <?= $placeholder !== null ? 'placeholder="' . esc($placeholder) . '"' : '' ?>
        <?= $descriptionId !== null ? 'aria-describedby="' . esc($descriptionId) . '"' : '' ?>
        <?= $error !== null ? 'aria-invalid="true"' : '' ?>
        <?= $required ? 'required' : '' ?>
        <?= $disabled ? 'disabled' : '' ?>
    >

    <?php if ($error !== null): ?>
        <p class="to-field__message to-field__message--error" id="<?= esc($id) ?>-error"><?= esc($error) ?></p>
    <?php elseif ($hint !== null): ?>
        <p class="to-field__message" id="<?= esc($id) ?>-hint"><?= esc($hint) ?></p>
    <?php endif ?>
</div>
