<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Capabilities;

final class ClickableCapability extends AbstractCapability
{
    public static function name(): string
    {
        return 'clickable';
    }

    public static function description(): ?string
    {
        return 'Can trigger an action through direct user interaction.';
    }
}
