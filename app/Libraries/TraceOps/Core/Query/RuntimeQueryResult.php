<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Query;

use App\Libraries\TraceOps\Core\Knowledge\SemanticEntity;
use Countable;
use IteratorAggregate;
use Traversable;

/** @implements IteratorAggregate<int, SemanticEntity> */
final class RuntimeQueryResult implements Countable, IteratorAggregate
{
    /** @param list<SemanticEntity> $entities */
    public function __construct(private readonly array $entities)
    {
    }

    /** @return list<SemanticEntity> */
    public function all(): array
    {
        return $this->entities;
    }

    public function first(): ?SemanticEntity
    {
        return $this->entities[0] ?? null;
    }

    public function count(): int
    {
        return count($this->entities);
    }

    public function isEmpty(): bool
    {
        return $this->entities === [];
    }

    /** @return list<array<string, mixed>> */
    public function catalog(): array
    {
        return array_map(
            static fn (SemanticEntity $entity): array => $entity->toArray(),
            $this->entities,
        );
    }

    /** @return Traversable<int, SemanticEntity> */
    public function getIterator(): Traversable
    {
        yield from $this->entities;
    }
}
