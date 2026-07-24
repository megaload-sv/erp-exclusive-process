<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Relationships;

final class Relationship
{
    /** @param array<string, mixed> $metadata */
    private function __construct(
        private readonly string $source,
        private readonly string $type,
        private readonly string $target,
        private readonly array $metadata = [],
    ) {
    }

    /** @param array<string, mixed> $metadata */
    public static function make(string $source, string $type, string $target, array $metadata = []): self
    {
        return new self($source, $type, $target, $metadata);
    }

    public function source(): string { return $this->source; }
    public function type(): string { return $this->type; }
    public function target(): string { return $this->target; }

    public function identity(): string
    {
        return sprintf('%s::%s::%s', $this->source, $this->type, $this->target);
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'identity' => $this->identity(),
            'source' => $this->source,
            'type' => $this->type,
            'target' => $this->target,
            'metadata' => $this->metadata,
        ], static fn (mixed $value): bool => $value !== []);
    }
}
