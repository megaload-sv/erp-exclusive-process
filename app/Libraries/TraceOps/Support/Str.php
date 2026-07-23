<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Support;

/**
 * String normalization utilities shared by TraceOps components.
 */
final class Str
{
    public static function value(mixed $value, string $default = ''): string
    {
        if (is_string($value) || is_numeric($value) || $value instanceof \Stringable) {
            return trim((string) $value);
        }

        return $default;
    }

    public static function nullable(mixed $value): ?string
    {
        $normalized = self::value($value);

        return $normalized === '' ? null : $normalized;
    }

    public static function slug(mixed $value, string $separator = '-'): string
    {
        $normalized = self::value($value);

        if ($normalized === '') {
            return '';
        }

        $separator = $separator === '' ? '-' : $separator;
        $normalized = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $normalized) ?: $normalized;
        $normalized = strtolower($normalized);
        $normalized = preg_replace('/[^a-z0-9]+/', $separator, $normalized) ?? '';

        return trim($normalized, $separator);
    }

    public static function identifier(mixed $value, string $fallback = 'component'): string
    {
        $identifier = self::slug($value);

        return $identifier !== '' ? $identifier : $fallback;
    }

    public static function startsWith(mixed $value, string $prefix): bool
    {
        return str_starts_with(self::value($value), $prefix);
    }
}
