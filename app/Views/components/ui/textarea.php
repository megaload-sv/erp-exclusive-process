<?php

/**
 * TraceOps textarea field component.
 *
 * @var string $name
 * @var string $label
 * @var string|null $id
 * @var string|null $value
 * @var string|null $placeholder
 * @var string|null $hint
 * @var string|null $error
 * @var int|null $rows
 * @var bool|null $required
 * @var bool|null $disabled
 */

$name = $name ?? '';
$label = $label ?? '';
$id = $id ?? $name;
$value = $value ?? '';
$placeholder = $placeholder ?? null;
$hint = $hint ?? null;
$error = $error ?? null;
$rows = max(2, (int) ($rows ?? 4));
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
