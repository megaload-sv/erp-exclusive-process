<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Metadata\Contracts;

interface DescriptorInterface
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
