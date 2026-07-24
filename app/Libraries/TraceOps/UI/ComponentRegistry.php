<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\UI;

use App\Libraries\TraceOps\Core\Metadata\ComponentDescriptor;
use InvalidArgumentException;

final class ComponentRegistry
{
    /** @var array<string, class-string<BaseComponent>> */
    private array $components = [];

    /** @param iterable<class-string<BaseComponent>> $components */
    public function __construct(iterable $components = [])
    {
        foreach ($components as $component) {
            $this->register($component);
        }
    }

    /** @param class-string<BaseComponent> $component */
    public function register(string $component): void
    {
        if (! is_subclass_of($component, BaseComponent::class)) {
            throw new InvalidArgumentException(sprintf(
                'Component [%s] must extend %s.',
                $component,
                BaseComponent::class,
            ));
        }

        $this->components[$component::name()] = $component;
        ksort($this->components);
    }

    public function has(string $type): bool
    {
        return isset($this->components[$type]);
    }

    /** @return class-string<BaseComponent>|null */
    public function find(string $type): ?string
    {
        return $this->components[$type] ?? null;
    }

    /** @return array<string, class-string<BaseComponent>> */
    public function all(): array
    {
        return $this->components;
    }

    /** @return array<string, ComponentDescriptor> */
    public function descriptors(): array
    {
        $descriptors = [];

        foreach ($this->components as $type => $component) {
            $descriptors[$type] = $component::describe();
        }

        return $descriptors;
    }

    public function count(): int
    {
        return count($this->components);
    }
}
