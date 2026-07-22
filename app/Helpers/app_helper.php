<?php

declare(strict_types=1);

if (! function_exists('app_name')) {
    function app_name(): string
    {
        return (string) (env('app.name') ?: 'TraceOps ERP');
    }
}

if (! function_exists('app_version')) {
    function app_version(): string
    {
        return (string) (env('app.version') ?: '0.1.0-alpha');
    }
}

if (! function_exists('app_environment')) {
    function app_environment(): string
    {
        return ENVIRONMENT;
    }
}
