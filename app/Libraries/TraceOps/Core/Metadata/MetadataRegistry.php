<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Metadata;

use App\Libraries\TraceOps\Core\Contracts\RegistryInterface;
use InvalidArgumentException;

final class MetadataRegistry implements RegistryInterface
{
    /** @var array<string, SemanticMetadata> */
    private array $items = [];

    /** @param array<string, SemanticMetadata> $items */
    public function __construct(array $items = [])
    {
        foreach ($items as $name => $metadata) {
            $this->register($name, $metadata);
        }
    }

    public function register(string $name, SemanticMetadata $metadata): void
    {
        $this->items[$name] = $metadata;
    }

    public function has(string $name): bool
    {
        return isset($this->items[$name]);
    }

    public function get(string $name): SemanticMetadata
    {
        if (! $this->has($name)) {
            throw new InvalidArgumentException("Metadata entry [{$name}] is not registered.");
        }

        return $this->items[$name];
    }

    /** @return array<string, SemanticMetadata> */
    public function all(): array
    {
        return $this->items;
    }

    /** @return array<string, array<string, mixed>> */
    public function catalog(): array
    {
        return array_map(
            static fn (SemanticMetadata $metadata): array => $metadata->toArray(),
            $this->items
        );
    }

    public function count(): int
    {
        return count($this->items);
    }
}