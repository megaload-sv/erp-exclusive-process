<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Runtime\Navigation;

use App\Libraries\TraceOps\Core\Metadata\ComponentDescriptor;
use App\Libraries\TraceOps\Core\Runtime\Contracts\RuntimeKernelInterface;
use App\Libraries\TraceOps\Core\Runtime\Services\RuntimeInspector;

final class RuntimeComponent extends SemanticObject
{
    public function __construct(
        RuntimeKernelInterface $kernel,
        private readonly ComponentDescriptor $descriptor,
    ) {
        parent::__construct($kernel);
    }

    public function identity(): string
    {
        return 'component.' . $this->type();
    }

    public function kind(): string
    {
        return 'component';
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

    /** @return array<string, mixed> */
    public function preview(): array
    {
        return [
            'view' => $this->descriptorData()['view'] ?? null,
            'data' => [],
        ];
    }

    public function inspector(): RuntimeInspector
    {
        return new RuntimeInspector($this);
    }

    public function descriptor(): ComponentDescriptor
    {
        return $this->descriptor;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            ...parent::toArray(),
            ...$this->descriptorData(),
            'properties' => $this->properties(),
            'capabilities' => $this->capabilities(),
            'preview' => $this->preview(),
        ];
    }

    /** @return array<string, mixed> */
    private function descriptorData(): array
    {
        return $this->descriptor->toArray();
    }
}
