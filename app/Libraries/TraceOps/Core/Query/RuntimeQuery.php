<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Query;

use App\Libraries\TraceOps\Core\Knowledge\SemanticEntity;
use App\Libraries\TraceOps\Core\Runtime\Contracts\RuntimeKernelInterface;

final class RuntimeQuery
{
    private ?string $kind = null;

    /** @var list<callable(SemanticEntity): bool> */
    private array $filters = [];

    private ?string $orderBy = null;
    private bool $descending = false;
    private ?int $limit = null;

    public function __construct(private readonly RuntimeKernelInterface $runtime)
    {
    }

    public function entities(): self
    {
        return $this->selectKind(null);
    }

    public function components(): self
    {
        return $this->selectKind('component');
    }

    public function properties(): self
    {
        return $this->selectKind('property');
    }

    public function types(): self
    {
        return $this->selectKind('type');
    }

    public function capabilities(): self
    {
        return $this->selectKind('capability');
    }

    public function metadata(): self
    {
        return $this->selectKind('metadata');
    }

    public function slots(): self
    {
        return $this->selectKind('slot');
    }

    public function whereKind(string $kind): self
    {
        return $this->selectKind($kind);
    }

    public function whereIdentity(string $identity): self
    {
        $this->filters[] = static fn (SemanticEntity $entity): bool => $entity->identity() === $identity;
        return $this;
    }

    public function whereName(string $name): self
    {
        $this->filters[] = static fn (SemanticEntity $entity): bool => $entity->name() === $name;
        return $this;
    }

    public function whereAttribute(string $path, mixed $value): self
    {
        $this->filters[] = static function (SemanticEntity $entity) use ($path, $value): bool {
            $current = $entity->attributes();

            foreach (explode('.', $path) as $segment) {
                if (! is_array($current) || ! array_key_exists($segment, $current)) {
                    return false;
                }

                $current = $current[$segment];
            }

            return $current === $value;
        };

        return $this;
    }

    public function supporting(string $capability): self
    {
        $identity = str_starts_with($capability, 'capability.')
            ? $capability
            : 'capability.' . $capability;

        $this->filters[] = fn (SemanticEntity $entity): bool => $this->isConnected(
            $entity,
            $identity,
            ['supports', 'hasCapability'],
        );

        return $this;
    }

    public function havingProperty(string $property): self
    {
        $this->filters[] = function (SemanticEntity $entity) use ($property): bool {
            foreach ($this->runtime->knowledge()->connectedFrom($entity->identity(), 'hasProperty') as $connected) {
                if ($connected->name() === $property || $connected->identity() === $property) {
                    return true;
                }
            }

            return false;
        };

        return $this;
    }

    public function orderBy(string $field, bool $descending = false): self
    {
        $this->orderBy = $field;
        $this->descending = $descending;
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = max(0, $limit);
        return $this;
    }

    public function get(): RuntimeQueryResult
    {
        $entities = $this->kind === null
            ? $this->runtime->knowledge()->all()
            : $this->runtime->knowledge()->ofKind($this->kind);

        foreach ($this->filters as $filter) {
            $entities = array_values(array_filter($entities, $filter));
        }

        if ($this->orderBy !== null) {
            $field = $this->orderBy;
            $descending = $this->descending;

            usort($entities, static function (SemanticEntity $left, SemanticEntity $right) use ($field, $descending): int {
                $leftValue = self::fieldValue($left, $field);
                $rightValue = self::fieldValue($right, $field);
                $comparison = $leftValue <=> $rightValue;
                return $descending ? -$comparison : $comparison;
            });
        }

        if ($this->limit !== null) {
            $entities = array_slice($entities, 0, $this->limit);
        }

        return new RuntimeQueryResult(array_values($entities));
    }

    public function first(): ?SemanticEntity
    {
        return $this->limit(1)->get()->first();
    }

    public function count(): int
    {
        return $this->get()->count();
    }

    private function selectKind(?string $kind): self
    {
        $this->kind = $kind;
        return $this;
    }

    /** @param list<string> $relationshipTypes */
    private function isConnected(SemanticEntity $entity, string $targetIdentity, array $relationshipTypes): bool
    {
        foreach ($relationshipTypes as $relationshipType) {
            foreach ($this->runtime->relationships()->from($entity->identity(), $relationshipType) as $relationship) {
                if ($relationship->target() === $targetIdentity) {
                    return true;
                }
            }
        }

        return false;
    }

    private static function fieldValue(SemanticEntity $entity, string $field): mixed
    {
        return match ($field) {
            'identity' => $entity->identity(),
            'kind' => $entity->kind(),
            'name' => $entity->name(),
            default => $entity->attributes()[$field] ?? null,
        };
    }
}
