<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Metadata;

final class SemanticMetadata
{
    /** @var list<string> */
    private array $tags = [];

    /** @var list<string> */
    private array $keywords = [];

    /** @var list<mixed> */
    private array $examples = [];

    private ?string $title = null;
    private ?string $summary = null;
    private ?string $description = null;
    private ?string $icon = null;
    private ?string $category = null;
    private ?string $group = null;
    private ?string $placeholder = null;
    private ?string $help = null;
    private ?string $since = null;
    private ?string $documentation = null;
    private ?int $order = null;
    private bool $deprecated = false;

    public static function make(): self
    {
        return new self();
    }

    public function title(string $value): self { $this->title = $value; return $this; }
    public function summary(string $value): self { $this->summary = $value; return $this; }
    public function description(string $value): self { $this->description = $value; return $this; }
    public function icon(string $value): self { $this->icon = $value; return $this; }
    public function category(string $value): self { $this->category = $value; return $this; }
    public function group(string $value): self { $this->group = $value; return $this; }
    public function placeholder(string $value): self { $this->placeholder = $value; return $this; }
    public function help(string $value): self { $this->help = $value; return $this; }
    public function since(string $value): self { $this->since = $value; return $this; }
    public function documentation(string $value): self { $this->documentation = $value; return $this; }
    public function order(int $value): self { $this->order = $value; return $this; }
    public function deprecated(bool $value = true): self { $this->deprecated = $value; return $this; }

    public function tags(string ...$values): self
    {
        $this->tags = array_values(array_unique([...$this->tags, ...$values]));
        return $this;
    }

    public function keywords(string ...$values): self
    {
        $this->keywords = array_values(array_unique([...$this->keywords, ...$values]));
        return $this;
    }

    public function example(mixed $value): self
    {
        $this->examples[] = $value;
        return $this;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'title' => $this->title,
            'summary' => $this->summary,
            'description' => $this->description,
            'icon' => $this->icon,
            'category' => $this->category,
            'group' => $this->group,
            'placeholder' => $this->placeholder,
            'help' => $this->help,
            'tags' => $this->tags,
            'keywords' => $this->keywords,
            'examples' => $this->examples,
            'since' => $this->since,
            'deprecated' => $this->deprecated,
            'documentation' => $this->documentation,
            'order' => $this->order,
        ], static fn (mixed $value): bool => $value !== null && $value !== [] && $value !== false);
    }
}