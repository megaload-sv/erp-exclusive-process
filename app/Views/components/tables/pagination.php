<?php

/**
 * TraceOps table pagination component.
 *
 * @var int|null $currentPage
 * @var int|null $totalPages
 * @var int|null $from
 * @var int|null $to
 * @var int|null $total
 */

$currentPage = max(1, (int) ($currentPage ?? 1));
$totalPages = max(1, (int) ($totalPages ?? 1));
$from = max(0, (int) ($from ?? 0));
$to = max(0, (int) ($to ?? 0));
$total = max(0, (int) ($total ?? 0));
?>
<nav class="to-table-pagination" aria-label="Paginación de registros">
    <p class="to-table-pagination__summary">
        Mostrando <strong><?= esc((string) $from) ?></strong>–<strong><?= esc((string) $to) ?></strong>
        de <strong><?= esc((string) $total) ?></strong> registros
    </p>
    <div class="to-table-pagination__controls">
        <button type="button" class="to-btn to-btn--secondary" <?= $currentPage <= 1 ? 'disabled' : '' ?>>Anterior</button>
        <span aria-current="page">Página <?= esc((string) $currentPage) ?> de <?= esc((string) $totalPages) ?></span>
        <button type="button" class="to-btn to-btn--secondary" <?= $currentPage >= $totalPages ? 'disabled' : '' ?>>Siguiente</button>
    </div>
</nav>
