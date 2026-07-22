<?php

/**
 * TraceOps form actions component.
 *
 * @var string|null $submitLabel
 * @var string|null $submitLoadingLabel
 * @var string|null $cancelLabel
 * @var string|null $cancelHref
 * @var bool|null $submitDisabled
 * @var string|null $note
 */

$submitLabel = $submitLabel ?? 'Guardar cambios';
$submitLoadingLabel = $submitLoadingLabel ?? 'Guardando...';
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
            'loadingLabel' => $submitLoadingLabel,
            'variant' => 'primary',
            'type' => 'submit',
            'disabled' => $submitDisabled,
            'attributes' => ['data-form-submit' => 'true'],
        ]) ?>
    </div>
</footer>
