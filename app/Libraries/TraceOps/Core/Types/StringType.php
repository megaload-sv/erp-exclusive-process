<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Types;

final class StringType extends AbstractType
{
    public static function name(): string { return 'string'; }
    public static function description(): ?string { return 'General-purpose textual value.'; }
    public static function phpType(): string { return 'string'; }
    public static function input(): ?string { return 'text'; }
}