<?php

use Config\TraceOps;

if (! function_exists('feature_enabled')) {
    function feature_enabled(string $feature): bool
    {
        /** @var TraceOps $config */
        $config = config(TraceOps::class);

        return (bool) ($config->features[$feature] ?? false);
    }
}

if (! function_exists('traceops_config')) {
    function traceops_config(): TraceOps
    {
        /** @var TraceOps $config */
        $config = config(TraceOps::class);

        return $config;
    }
}
