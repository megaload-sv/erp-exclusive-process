<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Contracts;

interface RegistryInterface
{
    public function has(string $name): bool;

    public function get(string $name): mixed;

    /** @return array<string, mixed> */
    public function all(): array;
}
