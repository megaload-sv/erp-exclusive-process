<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Metadata;

use App\Libraries\TraceOps\Core\Metadata\Contracts\DescriptorInterface;

final class PropertyDescriptor implements DescriptorInterface
{
    /**
     * @param list<mixed> $values
     */
    public function __construct(
        private readonly string $name,
        private readonly string $type = 'mixed',
        private readonly bool $required = false,
        private readonly mixed $default = null,
        private readonly array $values = [],
        private readonly ?string $description = null,
    ) {
    }

    /**
     * @param array<string, mixed> $schema
     */
    public static function fromSchema(string $name, array $schema): self
    {
        return new self(
            name: $name,
            type: (string) ($schema['type'] ?? 'mixed'),
            required: (bool) ($schema['required'] ?? false),
            default: $schema['default'] ?? null,
            values: array_values($schema['values'] ?? $schema['options'] ?? []),
            description: isset($schema['description']) ? (string) $schema['description'] : null,
        );
    }

    public function name(): string
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'type' => $this->type,
            'required' => $this->required,
            'default' => $this->default,
            'values' => $this->values,
            'description' => $this->description,
        ], static fn (mixed $value): bool => $value !== null && $value !== []);
    }
}
