<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Types;

final class UuidType extends AbstractType
{
    public static function name(): string { return 'uuid'; }
    public static function description(): ?string { return 'RFC 4122 universally unique identifier.'; }
    public static function phpType(): string { return 'string'; }
    public static function input(): ?string { return 'text'; }

    public static function metadata(): array
    {
        return array_merge(parent::metadata(), ['format' => 'uuid', 'readonlyRecommended' => true]);
    }
}