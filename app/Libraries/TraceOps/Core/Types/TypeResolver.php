<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Types;

use App\Libraries\TraceOps\Core\Contracts\TypeInterface;

final class TypeResolver
{
    public function __construct(private readonly TypeRegistry $registry)
    {
    }

    /** @param class-string<TypeInterface>|string $type */
    public function resolve(string $type): string
    {
        return $this->registry->get($type);
    }

    /** @param class-string<TypeInterface>|string $type */
    public function name(string $type): string
    {
        return $this->registry->normalize($type);
    }

    /** @param class-string<TypeInterface>|string $type */
    public function input(string $type): ?string
    {
        $class = $this->resolve($type);
        return $class::input();
    }

    /** @param class-string<TypeInterface>|string $type */
    public function metadata(string $type): array
    {
        $class = $this->resolve($type);
        return $class::metadata();
    }
}