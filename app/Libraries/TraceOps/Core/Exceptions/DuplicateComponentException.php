<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Exceptions;

use LogicException;

final class DuplicateComponentException extends LogicException
{
    public static function forName(string $name): self
    {
        return new self(sprintf('Component "%s" is already registered.', $name));
    }
}