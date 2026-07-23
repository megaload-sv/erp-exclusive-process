<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Contracts;

use App\Libraries\TraceOps\UI\BaseComponent;

interface ComponentFactoryInterface
{
    /**
     * @param array<string, mixed> $props
     */
    public function make(string $name, array $props = []): BaseComponent;
}