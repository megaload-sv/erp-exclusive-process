<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core;

use App\Libraries\TraceOps\Core\Contracts\ComponentFactoryInterface;
use App\Libraries\TraceOps\Core\Contracts\ComponentRegistryInterface;
use App\Libraries\TraceOps\UI\BaseComponent;

final class ComponentFactory implements ComponentFactoryInterface
{
    public function __construct(
        private readonly ComponentRegistryInterface $registry
    ) {
    }

    public function make(string $name, array $props = []): BaseComponent
    {
        $componentClass = $this->registry->resolve($name);

        return new $componentClass($props);
    }
}