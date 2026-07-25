<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Runtime\Navigation;

use App\Libraries\TraceOps\Core\Runtime\Contracts\RuntimeKernelInterface;

final class RuntimeCapability extends SemanticObject
{
    /** @param array<string, mixed> $descriptor */
    public function __construct(
        RuntimeKernelInterface $kernel,
        private readonly string $name,
        private readonly array $descriptor,
    ) {
        parent::__construct($kernel);
    }

    public function identity(): string
    {
        return 'capability.' . $this->name;
    }

    public function kind(): string
    {
        return 'capability';
    }

    public function name(): string
    {
        return $this->name;
    }

    public function title(): string
    {
        return (string) ($this->metadata()['title'] ?? ucfirst($this->name));
    }

    public function summary(): string
    {
        return (string) ($this->metadata()['summary'] ?? $this->descriptor['description'] ?? 'Runtime capability.');
    }

    /** @return list<string> */
    public function components(): array
    {
        $components = [];

        foreach ($this->kernel->components()->descriptors() as $descriptor) {
            if ($descriptor->supports($this->name)) {
                $components[] = $descriptor->type();
            }
        }

        return $components;
    }

    /** @return array<string, mixed> */
    public function descriptor(): array
    {
        return $this->descriptor;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            ...parent::toArray(),
            'name' => $this->name(),
            'descriptor' => $this->descriptor(),
            'components' => $this->components(),
        ];
    }
}
