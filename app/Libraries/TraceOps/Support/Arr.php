<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Support;

/**
 * Safe accessors and normalizers for component configuration arrays.
 */
final class Arr
{
    public static function has(array $data, string $key): bool
    {
        return array_key_exists($key, $data);
    }

    public static function value(array $data, string $key, mixed $default = null): mixed
    {
        return self::has($data, $key) ? $data[$key] : $default;
    }

    public static function string(array $data, string $key, string $default = ''): string
    {
        $value = self::value($data, $key, $default);

        if (is_string($value) || is_numeric($value) || $value instanceof \Stringable) {
            return trim((string) $value);
        }

        return $default;
    }

    public static function nullableString(array $data, string $key): ?string
    {
        $value = self::string($data, $key);

        return $value === '' ? null : $value;
    }

    public static function bool(array $data, string $key, bool $default = false): bool
    {
        $value = self::value($data, $key, $default);

        if (is_bool($value)) {
            return $value;
        }

        if (is_int($value)) {
            return $value !== 0;
        }

        if (is_string($value)) {
            $normalized = strtolower(trim($value));

            if (in_array($normalized, ['1', 'true', 'yes', 'on'], true)) {
                return true;
            }

            if (in_array($normalized, ['0', 'false', 'no', 'off', ''], true)) {
                return false;
            }
        }

        return $default;
    }

    public static function int(
        array $data,
        string $key,
        int $default = 0,
        ?int $min = null,
        ?int $max = null
    ): int {
        $value = self::value($data, $key, $default);
        $normalized = filter_var($value, FILTER_VALIDATE_INT);
        $normalized = $normalized === false ? $default : $normalized;

        if ($min !== null) {
            $normalized = max($min, $normalized);
        }

        if ($max !== null) {
            $normalized = min($max, $normalized);
        }

        return $normalized;
    }

    public static function array(array $data, string $key, array $default = []): array
    {
        $value = self::value($data, $key, $default);

        return is_array($value) ? $value : $default;
    }

    public static function callable(array $data, string $key): ?callable
    {
        $value = self::value($data, $key);

        return is_callable($value) ? $value : null;
    }

    public static function enum(
        array $data,
        string $key,
        array $allowed,
        string|int $default
    ): string|int {
        return Enum::value(self::value($data, $key, $default), $allowed, $default);
    }
}
