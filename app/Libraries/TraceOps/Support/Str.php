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
        $normalized = strtr($normalized, self::latinTransliterationMap());

        $transliterated = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $normalized);

        if ($transliterated !== false) {
            $normalized = $transliterated;
        }

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

    /**
     * Provides deterministic transliteration for common Latin characters
     * before falling back to the platform-dependent iconv implementation.
     *
     * @return array<string, string>
     */
    private static function latinTransliterationMap(): array
    {
        return [
            'Á' => 'A', 'À' => 'A', 'Â' => 'A', 'Ä' => 'A', 'Ã' => 'A', 'Å' => 'A',
            'á' => 'a', 'à' => 'a', 'â' => 'a', 'ä' => 'a', 'ã' => 'a', 'å' => 'a',
            'É' => 'E', 'È' => 'E', 'Ê' => 'E', 'Ë' => 'E',
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
            'Í' => 'I', 'Ì' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
            'Ó' => 'O', 'Ò' => 'O', 'Ô' => 'O', 'Ö' => 'O', 'Õ' => 'O',
            'ó' => 'o', 'ò' => 'o', 'ô' => 'o', 'ö' => 'o', 'õ' => 'o',
            'Ú' => 'U', 'Ù' => 'U', 'Û' => 'U', 'Ü' => 'U',
            'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
            'Ñ' => 'N', 'ñ' => 'n',
            'Ç' => 'C', 'ç' => 'c',
            'Ý' => 'Y', 'Ÿ' => 'Y', 'ý' => 'y', 'ÿ' => 'y',
            'Æ' => 'AE', 'æ' => 'ae', 'Œ' => 'OE', 'œ' => 'oe',
        ];
    }
}
