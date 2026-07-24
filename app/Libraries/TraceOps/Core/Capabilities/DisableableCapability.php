<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Capabilities;

final class DisableableCapability extends AbstractCapability
{
    public static function name(): string
    {
        return 'disableable';
    }

    public static function description(): ?string
    {
        return 'Can be placed in a non-interactive disabled state.';
    }
}
