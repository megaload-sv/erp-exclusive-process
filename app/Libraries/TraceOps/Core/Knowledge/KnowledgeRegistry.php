<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Knowledge;

use App\Libraries\TraceOps\Core\Relationships\Relationship;
use App\Libraries\TraceOps\Core\Relationships\RelationshipRegistry;

final class KnowledgeRegistry
{
    /** @var array<string, SemanticEntity> */
    private array $entities = [];

    public function __construct(
        iterable $entities = [],
        private readonly RelationshipRegistry $relationships = new RelationshipRegistry(),
    ) {
        foreach ($entities as $entity) {
            $this->register($entity);
        }
    }

    public function register(SemanticEntity $entity): void
    {
        $this->entities[$entity->identity()] = $entity;
    }

    public function relate(Relationship $relationship): void
    {
        $this->relationships->register($relationship);
    }

    public function get(string $identity): ?SemanticEntity
    {
        return $this->entities[$identity] ?? null;
    }

    public function has(string $identity): bool
    {
        return isset($this->entities[$identity]);
    }

    /** @return list<SemanticEntity> */
    public function all(): array
    {
        return array_values($this->entities);
    }

    /** @return list<SemanticEntity> */
    public function ofKind(string $kind): array
    {
        return array_values(array_filter(
            $this->entities,
            static fn (SemanticEntity $entity): bool => $entity->kind() === $kind
        ));
    }

    /** @return list<SemanticEntity> */
    public function connectedFrom(string $identity, ?string $relationshipType = null): array
    {
        $entities = [];

        foreach ($this->relationships->from($identity, $relationshipType) as $relationship) {
            $target = $this->get($relationship->target());
            if ($target !== null) {
                $entities[$target->identity()] = $target;
            }
        }

        return array_values($entities);
    }

    /** @return list<SemanticEntity> */
    public function connectedTo(string $identity, ?string $relationshipType = null): array
    {
        $entities = [];

        foreach ($this->relationships->to($identity, $relationshipType) as $relationship) {
            $source = $this->get($relationship->source());
            if ($source !== null) {
                $entities[$source->identity()] = $source;
            }
        }

        return array_values($entities);
    }

    public function relationships(): RelationshipRegistry
    {
        return $this->relationships;
    }

    public function count(): int
    {
        return count($this->entities);
    }

    /** @return array<string, int> */
    public function summary(): array
    {
        $summary = [];

        foreach ($this->entities as $entity) {
            $summary[$entity->kind()] = ($summary[$entity->kind()] ?? 0) + 1;
        }

        ksort($summary);
        return $summary;
    }

    /** @return list<array<string, mixed>> */
    public function catalog(): array
    {
        return array_map(
            static fn (SemanticEntity $entity): array => $entity->toArray(),
            $this->all()
        );
    }
}
