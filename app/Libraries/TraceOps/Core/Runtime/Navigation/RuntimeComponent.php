<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Runtime\Navigation;

use App\Libraries\TraceOps\Core\Knowledge\SemanticEntity;
use App\Libraries\TraceOps\Core\Metadata\ComponentDescriptor;
use App\Libraries\TraceOps\Core\Runtime\Contracts\RuntimeKernelInterface;

final class RuntimeComponent
{
    public function __construct(
        private readonly RuntimeKernelInterface $kernel,
        private readonly ComponentDescriptor $descriptor,
    ) {
    }

    public function identity(): string
    {
        return 'component.' . $this->type();
    }

    public function type(): string
    {
        return $this->descriptor->type();
    }

    public function title(): string
    {
        return (string) ($this->metadata()['title'] ?? $this->descriptorData()['displayName'] ?? ucfirst($this->type()));
    }

    public function summary(): string
    {
        return (string) ($this->metadata()['summary'] ?? 'Runtime component.');
    }

    /** @return list<array<string, mixed>> */
    public function properties(): array
    {
        return $this->descriptorData()['properties'] ?? [];
    }

    /** @return list<string> */
    public function capabilities(): array
    {
        return $this->descriptor->capabilities();
    }

    /** @return array<string, mixed> */
    public function metadata(): array
    {
        if (! $this->kernel->metadata()->has($this->identity())) {
            return [];
        }

        return $this->kernel->metadata()->get($this->identity())->toArray();
    }

    /** @return list<array<string, mixed>> */
    public function relationships(): array
    {
        return array_values(array_filter(
            $this->kernel->relationships()->catalog(),
            fn (array $relationship): bool =>
                ($relationship['source'] ?? null) === $this->identity()
                || ($relationship['target'] ?? null) === $this->identity()
                || ($relationship['source'] ?? null) === $this->type()
                || ($relationship['target'] ?? null) === $this->type()
        ));
    }

    /** @return array<string, mixed>|null */
    public function knowledge(): ?array
    {
        $entity = $this->kernel->knowledge()->get($this->identity());

        return $entity instanceof SemanticEntity ? $entity->toArray() : null;
    }

    /** @return array<string, mixed> */
    public function preview(): array
    {
        return [
            'view' => $this->descriptorData()['view'] ?? null,
            'data' => [],
        ];
    }

    public function descriptor(): ComponentDescriptor
    {
        return $this->descriptor;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            ...$this->descriptorData(),
            'identity' => $this->identity(),
            'title' => $this->title(),
            'summary' => $this->summary(),
            'metadata' => $this->metadata(),
            'relationships' => $this->relationships(),
            'knowledge' => $this->knowledge(),
            'preview' => $this->preview(),
        ];
    }

    /** @return array<string, mixed> */
    private function descriptorData(): array
    {
        return $this->descriptor->toArray();
    }
}
