<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Support;

/**
 * Normalizes scalar values against an explicit allow-list.
 */
final class Enum
{
    public static function value(
        mixed $value,
        array $allowed,
        string|int $default,
        bool $caseSensitive = true
    ): string|int {
        if (!is_string($value) && !is_int($value)) {
            return $default;
        }

        if ($caseSensitive) {
            return in_array($value, $allowed, true) ? $value : $default;
        }

        if (!is_string($value)) {
            return in_array($value, $allowed, true) ? $value : $default;
        }

        $normalized = strtolower(trim($value));

        foreach ($allowed as $candidate) {
            if (is_string($candidate) && strtolower($candidate) === $normalized) {
                return $candidate;
            }
        }

        return $default;
    }

    public static function nullable(
        mixed $value,
        array $allowed,
        bool $caseSensitive = true
    ): string|int|null {
        if (!is_string($value) && !is_int($value)) {
            return null;
        }

        $sentinel = new \stdClass();
        $result = self::valueOrSentinel($value, $allowed, $sentinel, $caseSensitive);

        return $result === $sentinel ? null : $result;
    }

    private static function valueOrSentinel(
        string|int $value,
        array $allowed,
        object $sentinel,
        bool $caseSensitive
    ): string|int|object {
        if ($caseSensitive) {
            return in_array($value, $allowed, true) ? $value : $sentinel;
        }

        if (is_int($value)) {
            return in_array($value, $allowed, true) ? $value : $sentinel;
        }

        $normalized = strtolower(trim($value));

        foreach ($allowed as $candidate) {
            if (is_string($candidate) && strtolower($candidate) === $normalized) {
                return $candidate;
            }
        }

        return $sentinel;
    }
}
