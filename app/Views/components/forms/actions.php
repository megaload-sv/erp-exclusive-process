<?php

/**
 * TraceOps form actions component.
 *
 * @var string|null $submitLabel
 * @var string|null $cancelLabel
 * @var string|null $cancelHref
 * @var bool|null $submitDisabled
 * @var string|null $note
 */

$submitLabel = $submitLabel ?? 'Guardar cambios';
$cancelLabel = $cancelLabel ?? 'Cancelar';
$cancelHref = $cancelHref ?? null;
$submitDisabled = $submitDisabled ?? false;
$note = $note ?? null;
?>
<footer class="to-form-actions">
    <div class="to-form-actions__meta">
        <?php if ($note !== null): ?>
            <p><?= esc($note) ?></p>
        <?php endif ?>
    </div>

    <div class="to-form-actions__buttons">
        <?= view('components/ui/button', [
            'label' => $cancelLabel,
            'variant' => 'secondary',
            'href' => $cancelHref,
            'type' => $cancelHref === null ? 'button' : null,
        ]) ?>
        <?= view('components/ui/button', [
            'label' => $submitLabel,
            'variant' => 'primary',
            'type' => 'submit',
            'disabled' => $submitDisabled,
        ]) ?>
    </div>
</footer>
