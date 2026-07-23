<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Exceptions;

use RuntimeException;

final class ComponentNotFoundException extends RuntimeException
{
    public static function forName(string $name): self
    {
        return new self(sprintf('Component "%s" is not registered.', $name));
    }
}