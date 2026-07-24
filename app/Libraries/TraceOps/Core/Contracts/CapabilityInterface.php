<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Contracts;

interface CapabilityInterface
{
    public static function name(): string;

    public static function description(): ?string;
}
