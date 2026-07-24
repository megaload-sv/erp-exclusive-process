<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\UI;

use App\Libraries\TraceOps\Core\Contracts\TypeInterface;
use App\Libraries\TraceOps\Support\Arr;
use App\Libraries\TraceOps\Support\Str;

final class ComponentNormalizer
{
    /**
     * @param array<string, mixed> $data
     * @param array<string, array<string, mixed>> $schema
     * @return array<string, mixed>
     */
    public static function normalize(array $data, array $schema): array
    {
        $normalized = [];

        foreach ($schema as $key => $rules) {
            $declaredType = is_string($rules['type'] ?? null) ? $rules['type'] : 'string';
            $type = is_subclass_of($declaredType, TypeInterface::class)
                ? $declaredType::name()
                : $declaredType;
            $default = $rules['default'] ?? null;
            $nullable = (bool) ($rules['nullable'] ?? false);

            $normalized[$key] = match ($type) {
                'nullable-string' => Arr::nullableString($data, $key),
                'string', 'email', 'uuid' => $nullable
                    ? Arr::nullableString($data, $key)
                    : Arr::string($data, $key, is_string($default) ? $default : ''),
                'bool', 'boolean' => Arr::bool($data, $key, is_bool($default) ? $default : false),
                'int', 'integer' => Arr::int(
                    $data,
                    $key,
                    is_int($default) ? $default : 0,
                    is_int($rules['min'] ?? null) ? $rules['min'] : null,
                    is_int($rules['max'] ?? null) ? $rules['max'] : null,
                ),
                'array' => Arr::array($data, $key, is_array($default) ? $default : []),
                'callable' => Arr::callable($data, $key),
                'enum' => Arr::enum(
                    $data,
                    $key,
                    is_array($rules['allowed'] ?? null) ? $rules['allowed'] : [],
                    is_string($default) || is_int($default) ? $default : '',
                ),
                default => Arr::string($data, $key, is_string($default) ? $default : ''),
            };
        }

        return $normalized;
    }

    public static function id(mixed $value, string $fallback = 'component'): string
    {
        return Str::identifier($value, $fallback);
    }

    /**
     * @return array<string, scalar>
     */
    public static function attributes(mixed $attributes): array
    {
        if (! is_array($attributes)) {
            return [];
        }

        $safe = [];

        foreach ($attributes as $name => $value) {
            if (! is_string($name)
                || preg_match('/^[a-zA-Z_:][a-zA-Z0-9:._-]*$/', $name) !== 1
                || ! is_scalar($value)
            ) {
                continue;
            }

            $safe[$name] = $value;
        }

        return $safe;
    }
}
