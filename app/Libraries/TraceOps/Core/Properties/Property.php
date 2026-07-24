<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Properties;

use App\Libraries\TraceOps\Core\Contracts\TypeInterface;
use App\Libraries\TraceOps\Core\Metadata\SemanticMetadata;

final class Property
{
    /** @var class-string<TypeInterface>|string */
    private string $type = 'string';
    private ?string $label = null;
    private ?string $description = null;
    private bool $required = false;
    private bool $searchable = false;
    private bool $sortable = false;
    private bool $filterable = false;
    private mixed $default = null;
    private ?SemanticMetadata $metadata = null;

    /** @var list<string> */
    private array $validation = [];

    private function __construct(private readonly string $name)
    {
    }

    public static function make(string $name): self
    {
        return new self($name);
    }

    /** @param class-string<TypeInterface>|string $type */
    public function type(string $type): self { $this->type = $type; return $this; }
    public function label(string $label): self { $this->label = $label; return $this; }
    public function description(string $description): self { $this->description = $description; return $this; }
    public function required(bool $required = true): self { $this->required = $required; return $this; }
    public function searchable(bool $value = true): self { $this->searchable = $value; return $this; }
    public function sortable(bool $value = true): self { $this->sortable = $value; return $this; }
    public function filterable(bool $value = true): self { $this->filterable = $value; return $this; }
    public function default(mixed $value): self { $this->default = $value; return $this; }
    public function metadata(SemanticMetadata $metadata): self { $this->metadata = $metadata; return $this; }
    public function validation(string ...$rules): self { $this->validation = array_values(array_unique([...$this->validation, ...$rules])); return $this; }

    /** @return array<string, mixed> */
    public function toSchema(): array
    {
        return array_filter([
            'type' => $this->type,
            'label' => $this->label,
            'description' => $this->description,
            'required' => $this->required,
            'searchable' => $this->searchable,
            'sortable' => $this->sortable,
            'filterable' => $this->filterable,
            'default' => $this->default,
            'validation' => $this->validation,
            'metadata' => $this->metadata?->toArray(),
        ], static fn (mixed $value): bool => $value !== null && $value !== []);
    }

    public function name(): string { return $this->name; }
}