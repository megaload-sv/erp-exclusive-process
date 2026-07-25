<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Runtime\Navigation;

use App\Libraries\TraceOps\Core\Knowledge\SemanticEntity;
use App\Libraries\TraceOps\Core\Runtime\Contracts\RuntimeKernelInterface;

abstract class SemanticObject
{
    public function __construct(
        protected readonly RuntimeKernelInterface $kernel,
    ) {
    }

    abstract public function identity(): string;

    abstract public function kind(): string;

    abstract public function title(): string;

    public function summary(): string
    {
        return (string) ($this->metadata()['summary'] ?? 'Runtime semantic object.');
    }

    /** @return array<string, mixed> */
    public function metadata(): array
    {
        if (! $this->kernel->metadata()->has($this->identity())) {
            return [];
        }

        return $this->kernel->metadata()->get($this->identity())->toArray();
    }

    /** @return list<string> */
    public function tags(): array
    {
        return array_values(array_map('strval', $this->metadata()['tags'] ?? []));
    }

    /** @return list<array<string, mixed>> */
    public function relationships(): array
    {
        return array_values(array_filter(
            $this->kernel->relationships()->catalog(),
            fn (array $relationship): bool =>
                ($relationship['source'] ?? null) === $this->identity()
                || ($relationship['target'] ?? null) === $this->identity()
        ));
    }

    /** @return array<string, mixed>|null */
    public function knowledge(): ?array
    {
        $entity = $this->kernel->knowledge()->get($this->identity());

        return $entity instanceof SemanticEntity ? $entity->toArray() : null;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'identity' => $this->identity(),
            'kind' => $this->kind(),
            'title' => $this->title(),
            'summary' => $this->summary(),
            'tags' => $this->tags(),
            'metadata' => $this->metadata(),
            'relationships' => $this->relationships(),
            'knowledge' => $this->knowledge(),
        ];
    }
}
