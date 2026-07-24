<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Metadata;

use App\Libraries\TraceOps\Core\Metadata\Contracts\DescriptorInterface;

final class ComponentDescriptor implements DescriptorInterface
{
    /**
     * @param list<PropertyDescriptor> $properties
     * @param list<string> $slots
     * @param list<string> $capabilities
     * @param list<string> $events
     */
    public function __construct(
        private readonly string $type,
        private readonly string $className,
        private readonly string $view,
        private readonly array $properties = [],
        private readonly array $slots = [],
        private readonly array $capabilities = [],
        private readonly array $events = [],
        private readonly ?string $displayName = null,
        private readonly ?string $category = null,
    ) {
    }

    /**
     * @param array<string, array<string, mixed>> $schema
     * @param list<string> $slots
     * @param list<string> $capabilities
     * @param list<string> $events
     */
    public static function fromComponent(
        string $className,
        string $type,
        string $view,
        array $schema,
        array $slots = [],
        array $capabilities = [],
        array $events = [],
        ?string $displayName = null,
        ?string $category = null,
    ): self {
        $properties = [];

        foreach ($schema as $name => $definition) {
            $properties[] = PropertyDescriptor::fromSchema($name, $definition);
        }

        return new self(
            type: $type,
            className: $className,
            view: $view,
            properties: $properties,
            slots: array_values($slots),
            capabilities: array_values($capabilities),
            events: array_values($events),
            displayName: $displayName,
            category: $category,
        );
    }

    public function type(): string
    {
        return $this->type;
    }

    /** @return list<PropertyDescriptor> */
    public function properties(): array
    {
        return $this->properties;
    }

    public function toArray(): array
    {
        return array_filter([
            'type' => $this->type,
            'class' => $this->className,
            'displayName' => $this->displayName,
            'category' => $this->category,
            'view' => $this->view,
            'properties' => array_map(
                static fn (PropertyDescriptor $property): array => $property->toArray(),
                $this->properties
            ),
            'slots' => $this->slots,
            'capabilities' => $this->capabilities,
            'events' => $this->events,
        ], static fn (mixed $value): bool => $value !== null && $value !== []);
    }
}
