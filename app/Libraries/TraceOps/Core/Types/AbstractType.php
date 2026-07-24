<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Types;

use App\Libraries\TraceOps\Core\Contracts\TypeInterface;

abstract class AbstractType implements TypeInterface
{
    public static function description(): ?string
    {
        return null;
    }

    public static function input(): ?string
    {
        return null;
    }

    public static function metadata(): array
    {
        return [
            'name' => static::name(),
            'description' => static::description(),
            'phpType' => static::phpType(),
            'input' => static::input(),
        ];
    }
}