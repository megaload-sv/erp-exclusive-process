<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Metadata;

use App\Libraries\TraceOps\Core\Metadata\Contracts\DescriptorInterface;
use JsonException;

final class DescriptorSerializer
{
    /** @throws JsonException */
    public function toJson(DescriptorInterface $descriptor, bool $pretty = false): string
    {
        $flags = JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES;

        if ($pretty) {
            $flags |= JSON_PRETTY_PRINT;
        }

        return json_encode($descriptor->toArray(), $flags);
    }
}
