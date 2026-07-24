<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Types;

final class EmailType extends AbstractType
{
    public static function name(): string { return 'email'; }
    public static function description(): ?string { return 'Electronic mail address with email-aware validation and presentation.'; }
    public static function phpType(): string { return 'string'; }
    public static function input(): ?string { return 'email'; }

    public static function metadata(): array
    {
        return array_merge(parent::metadata(), ['format' => 'email', 'validation' => ['email']]);
    }
}