<?php

declare(strict_types=1);

namespace App\Libraries;

final class ActivityLogger
{
    public function record(string $action, array $context = []): void
    {
        log_message('info', '[TraceOps] {action} {context}', [
            'action' => $action,
            'context' => json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ]);
    }
}
