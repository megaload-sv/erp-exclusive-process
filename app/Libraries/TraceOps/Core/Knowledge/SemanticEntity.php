<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Knowledge;

final class SemanticEntity
{
    /** @param array<string, mixed> $attributes */
    private function __construct(
        private readonly string $identity,
        private readonly string $kind,
        private readonly string $name,
        private readonly array $attributes = [],
    ) {
    }

    /** @param array<string, mixed> $attributes */
    public static function make(string $identity, string $kind, string $name, array $attributes = []): self
    {
        return new self($identity, $kind, $name, $attributes);
    }

    public function identity(): string { return $this->identity; }
    public function kind(): string { return $this->kind; }
    public function name(): string { return $this->name; }

    /** @return array<string, mixed> */
    public function attributes(): array { return $this->attributes; }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'identity' => $this->identity,
            'kind' => $this->kind,
            'name' => $this->name,
            'attributes' => $this->attributes,
        ], static fn (mixed $value): bool => $value !== []);
    }
}
