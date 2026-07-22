<?php

/**
 * TraceOps validation summary component.
 *
 * @var array<string, string>|null $errors Field id => message.
 * @var string|null $title
 * @var string|null $id
 */

$errors = $errors ?? [];
$title = $title ?? 'Revisa la información ingresada';
$id = $id ?? 'validation-summary';
$titleId = $id . '-title';

if ($errors === []) {
    return;
}
?>
<section
    class="to-validation-summary"
    id="<?= esc($id) ?>"
    role="alert"
    aria-labelledby="<?= esc($titleId) ?>"
    tabindex="-1"
>
    <div class="to-validation-summary__icon" aria-hidden="true">!</div>
    <div>
        <h3 id="<?= esc($titleId) ?>"><?= esc($title) ?></h3>
        <p>Corrige los siguientes campos antes de continuar:</p>
        <ul>
            <?php foreach ($errors as $fieldId => $message): ?>
                <li><a href="#<?= esc($fieldId) ?>"><?= esc($message) ?></a></li>
            <?php endforeach ?>
        </ul>
    </div>
</section>
