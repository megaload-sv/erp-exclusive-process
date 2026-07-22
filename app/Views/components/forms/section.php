<?php

/**
 * TraceOps form section component.
 *
 * @var string $title
 * @var string|null $description
 * @var string $content Trusted HTML rendered by child components.
 * @var string|null $legendId
 */

$title = $title ?? '';
$description = $description ?? null;
$content = $content ?? '';
$legendId = $legendId ?? 'form-section-' . substr(md5($title), 0, 8);
?>
<section class="to-form-section" aria-labelledby="<?= esc($legendId) ?>">
    <header class="to-form-section__header">
        <h3 id="<?= esc($legendId) ?>"><?= esc($title) ?></h3>
        <?php if ($description !== null): ?>
            <p><?= esc($description) ?></p>
        <?php endif ?>
    </header>

    <div class="to-form-section__body">
        <?= $content ?>
    </div>
</section>
