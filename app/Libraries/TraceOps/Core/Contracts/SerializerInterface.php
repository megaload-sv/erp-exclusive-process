<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Contracts;

interface SerializerInterface
{
    public function serialize(mixed $value): string;
}
