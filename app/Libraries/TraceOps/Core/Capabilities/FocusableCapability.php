<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Capabilities;

final class FocusableCapability extends AbstractCapability
{
    public static function name(): string
    {
        return 'focusable';
    }

    public static function description(): ?string
    {
        return 'Can participate in keyboard and programmatic focus flows.';
    }
}
