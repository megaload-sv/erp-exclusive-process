<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core;

use App\Libraries\TraceOps\UI\BaseComponent;

final class ComponentManager
{
    private ComponentRegistry $registry;

    private ComponentFactory $factory;

    /**
     * @param iterable<class-string<BaseComponent>> $components
     */
    public function __construct(iterable $components = [])
    {
        $this->registry = new ComponentRegistry($components);
        $this->factory = new ComponentFactory($this->registry);
    }

    /**
     * @param class-string<BaseComponent> $componentClass
     */
    public function register(string $componentClass): self
    {
        $this->registry->register($componentClass);

        return $this;
    }

    /**
     * @param array<string, mixed> $props
     */
    public function make(string $name, array $props = []): BaseComponent
    {
        return $this->factory->make($name, $props);
    }

    public function has(string $name): bool
    {
        return $this->registry->has($name);
    }

    /**
     * @return array<string, class-string<BaseComponent>>
     */
    public function all(): array
    {
        return $this->registry->all();
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function metadata(): array
    {
        return $this->registry->metadata();
    }
}