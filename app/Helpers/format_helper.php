<?php

declare(strict_types=1);

if (! function_exists('format_boolean')) {
    function format_boolean(bool $value): string
    {
        return $value ? 'Sí' : 'No';
    }
}

if (! function_exists('format_bytes')) {
    function format_bytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $power = $bytes > 0 ? min((int) floor(log($bytes, 1024)), count($units) - 1) : 0;
        $value = $bytes / (1024 ** $power);

        return number_format($value, $precision) . ' ' . $units[$power];
    }
}
