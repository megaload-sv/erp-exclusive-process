<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core;

use App\Libraries\TraceOps\Core\Contracts\ComponentRegistryInterface;
use App\Libraries\TraceOps\Core\Exceptions\ComponentNotFoundException;
use App\Libraries\TraceOps\Core\Exceptions\DuplicateComponentException;
use App\Libraries\TraceOps\Core\Exceptions\InvalidComponentException;
use App\Libraries\TraceOps\UI\BaseComponent;

final class ComponentRegistry implements ComponentRegistryInterface
{
    /**
     * @var array<string, class-string<BaseComponent>>
     */
    private array $components = [];

    /**
     * @param iterable<class-string<BaseComponent>> $components
     */
    public function __construct(iterable $components = [])
    {
        foreach ($components as $component) {
            $this->register($component);
        }
    }

    public function register(string $componentClass): void
    {
        if (! is_subclass_of($componentClass, BaseComponent::class)) {
            throw InvalidComponentException::forClass($componentClass);
        }

        $name = trim($componentClass::name());

        if ($name === '') {
            throw InvalidComponentException::forEmptyName($componentClass);
        }

        if ($this->has($name)) {
            throw DuplicateComponentException::forName($name);
        }

        $this->components[$name] = $componentClass;
        ksort($this->components);
    }

    public function resolve(string $name): string
    {
        $name = trim($name);

        if (! $this->has($name)) {
            throw ComponentNotFoundException::forName($name);
        }

        return $this->components[$name];
    }

    public function has(string $name): bool
    {
        return array_key_exists(trim($name), $this->components);
    }

    public function all(): array
    {
        return $this->components;
    }

    public function metadata(): array
    {
        $metadata = [];

        foreach ($this->components as $name => $componentClass) {
            $metadata[$name] = $componentClass::metadata();
        }

        return $metadata;
    }
}