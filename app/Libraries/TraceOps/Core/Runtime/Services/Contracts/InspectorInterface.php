<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Runtime\Services\Contracts;

interface InspectorInterface
{
    /** @return array<string, mixed> */
    public function describe(): array;

    /** @return array<string, mixed> */
    public function general(): array;

    /** @return list<array<string, mixed>> */
    public function properties(): array;

    /** @return array<string, mixed> */
    public function diagnostics(): array;
}
