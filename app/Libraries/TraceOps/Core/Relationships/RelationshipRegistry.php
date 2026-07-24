<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Relationships;

final class RelationshipRegistry
{
    /** @var array<string, Relationship> */
    private array $relationships = [];

    /** @param iterable<Relationship> $relationships */
    public function __construct(iterable $relationships = [])
    {
        foreach ($relationships as $relationship) {
            $this->register($relationship);
        }
    }

    public function register(Relationship $relationship): void
    {
        $this->relationships[$relationship->identity()] = $relationship;
    }

    /** @return list<Relationship> */
    public function all(): array
    {
        return array_values($this->relationships);
    }

    /** @return list<Relationship> */
    public function from(string $source, ?string $type = null): array
    {
        return array_values(array_filter(
            $this->relationships,
            static fn (Relationship $relationship): bool =>
                $relationship->source() === $source
                && ($type === null || $relationship->type() === $type)
        ));
    }

    /** @return list<Relationship> */
    public function to(string $target, ?string $type = null): array
    {
        return array_values(array_filter(
            $this->relationships,
            static fn (Relationship $relationship): bool =>
                $relationship->target() === $target
                && ($type === null || $relationship->type() === $type)
        ));
    }

    /** @return list<Relationship> */
    public function ofType(string $type): array
    {
        return array_values(array_filter(
            $this->relationships,
            static fn (Relationship $relationship): bool => $relationship->type() === $type
        ));
    }

    public function count(): int
    {
        return count($this->relationships);
    }

    /** @return list<array<string, mixed>> */
    public function catalog(): array
    {
        return array_map(
            static fn (Relationship $relationship): array => $relationship->toArray(),
            $this->all()
        );
    }
}
