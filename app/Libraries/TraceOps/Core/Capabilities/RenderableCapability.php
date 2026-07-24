<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Capabilities;

final class RenderableCapability extends AbstractCapability
{
    public static function name(): string
    {
        return 'renderable';
    }

    public static function description(): ?string
    {
        return 'Can produce a visual representation through the Runtime renderer.';
    }
}
