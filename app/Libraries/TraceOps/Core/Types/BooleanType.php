<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Types;

final class BooleanType extends AbstractType
{
    public static function name(): string { return 'boolean'; }
    public static function description(): ?string { return 'Binary true or false value.'; }
    public static function phpType(): string { return 'bool'; }
    public static function input(): ?string { return 'switch'; }
}