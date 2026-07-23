<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Contracts;

use App\Libraries\TraceOps\UI\BaseComponent;

interface ComponentRegistryInterface
{
    /**
     * @param class-string<BaseComponent> $componentClass
     */
    public function register(string $componentClass): void;

    /**
     * @return class-string<BaseComponent>
     */
    public function resolve(string $name): string;

    public function has(string $name): bool;

    /**
     * @return array<string, class-string<BaseComponent>>
     */
    public function all(): array;

    /**
     * @return array<string, array<string, mixed>>
     */
    public function metadata(): array;
}