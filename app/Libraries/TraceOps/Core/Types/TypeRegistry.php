<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Types;

use App\Libraries\TraceOps\Core\Contracts\RegistryInterface;
use App\Libraries\TraceOps\Core\Contracts\TypeInterface;
use InvalidArgumentException;

final class TypeRegistry implements RegistryInterface
{
    /** @var array<string, class-string<TypeInterface>> */
    private array $types = [];

    /** @param iterable<class-string<TypeInterface>> $types */
    public function __construct(iterable $types = [])
    {
        foreach ($types as $type) {
            $this->register($type);
        }
    }

    /** @param class-string<TypeInterface> $type */
    public function register(string $type): void
    {
        if (! is_subclass_of($type, TypeInterface::class)) {
            throw new InvalidArgumentException("{$type} must implement " . TypeInterface::class);
        }

        $name = $type::name();
        if ($name === '' || isset($this->types[$name])) {
            throw new InvalidArgumentException("Invalid or duplicate semantic type: {$name}");
        }

        $this->types[$name] = $type;
    }

    public function has(string $name): bool
    {
        return isset($this->types[$this->normalize($name)]);
    }

    /** @return class-string<TypeInterface> */
    public function get(string $name): string
    {
        $name = $this->normalize($name);
        if (! isset($this->types[$name])) {
            throw new InvalidArgumentException("Unknown semantic type: {$name}");
        }

        return $this->types[$name];
    }

    /** @return array<string, class-string<TypeInterface>> */
    public function all(): array
    {
        return $this->types;
    }

    /** @return array<string, array<string, mixed>> */
    public function descriptors(): array
    {
        $result = [];
        foreach ($this->types as $name => $type) {
            $result[$name] = $type::metadata();
        }
        return $result;
    }

    public function normalize(string $type): string
    {
        return is_subclass_of($type, TypeInterface::class) ? $type::name() : strtolower(trim($type));
    }
}