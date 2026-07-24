<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Contracts;

interface TypeInterface
{
    public static function name(): string;

    public static function description(): ?string;

    public static function phpType(): string;

    public static function input(): ?string;

    /** @return array<string, mixed> */
    public static function metadata(): array;
}