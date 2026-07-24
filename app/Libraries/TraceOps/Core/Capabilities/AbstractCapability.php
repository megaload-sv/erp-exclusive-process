<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Capabilities;

use App\Libraries\TraceOps\Core\Contracts\CapabilityInterface;

abstract class AbstractCapability implements CapabilityInterface
{
    public static function description(): ?string
    {
        return null;
    }

    /** @return array{name: string, class: class-string<CapabilityInterface>, description: ?string} */
    final public static function describe(): array
    {
        return [
            'name' => static::name(),
            'class' => static::class,
            'description' => static::description(),
        ];
    }
}
