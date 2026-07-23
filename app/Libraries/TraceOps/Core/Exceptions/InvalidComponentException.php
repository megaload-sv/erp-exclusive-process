<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Exceptions;

use InvalidArgumentException;

final class InvalidComponentException extends InvalidArgumentException
{
    public static function forClass(string $class): self
    {
        return new self(sprintf('Class "%s" must extend %s.', $class, \App\Libraries\TraceOps\UI\BaseComponent::class));
    }

    public static function forEmptyName(string $class): self
    {
        return new self(sprintf('Component "%s" must declare a non-empty name.', $class));
    }
}