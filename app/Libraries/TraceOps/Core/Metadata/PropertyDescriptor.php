<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Metadata;

use App\Libraries\TraceOps\Core\Contracts\TypeInterface;
use App\Libraries\TraceOps\Core\Metadata\Contracts\DescriptorInterface;

final class PropertyDescriptor implements DescriptorInterface
{
    /** @param list<mixed> $values @param list<string> $validation @param array<string, mixed> $metadata */
    public function __construct(
        private readonly string $name,
        private readonly string $type = 'mixed',
        private readonly bool $required = false,
        private readonly mixed $default = null,
        private readonly array $values = [],
        private readonly ?string $description = null,
        private readonly ?string $label = null,
        private readonly bool $searchable = false,
        private readonly bool $sortable = false,
        private readonly bool $filterable = false,
        private readonly array $validation = [],
        private readonly array $metadata = [],
    ) {
    }

    /** @param array<string, mixed> $schema */
    public static function fromSchema(string $name, array $schema): self
    {
        $declaredType = (string) ($schema['type'] ?? 'mixed');
        $semanticType = is_subclass_of($declaredType, TypeInterface::class)
            ? $declaredType::name()
            : $declaredType;

        return new self(
            name: $name,
            type: $semanticType,
            required: (bool) ($schema['required'] ?? false),
            default: $schema['default'] ?? null,
            values: array_values($schema['values'] ?? $schema['options'] ?? []),
            description: isset($schema['description']) ? (string) $schema['description'] : null,
            label: isset($schema['label']) ? (string) $schema['label'] : null,
            searchable: (bool) ($schema['searchable'] ?? false),
            sortable: (bool) ($schema['sortable'] ?? false),
            filterable: (bool) ($schema['filterable'] ?? false),
            validation: array_values($schema['validation'] ?? []),
            metadata: is_array($schema['metadata'] ?? null) ? $schema['metadata'] : [],
        );
    }

    public function name(): string { return $this->name; }
    public function type(): string { return $this->type; }

    /** @return array<string, mixed> */
    public function metadata(): array { return $this->metadata; }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'label' => $this->label,
            'type' => $this->type,
            'required' => $this->required,
            'default' => $this->default,
            'values' => $this->values,
            'description' => $this->description,
            'searchable' => $this->searchable,
            'sortable' => $this->sortable,
            'filterable' => $this->filterable,
            'validation' => $this->validation,
            'metadata' => $this->metadata,
        ], static fn (mixed $value): bool => $value !== null && $value !== []);
    }
}