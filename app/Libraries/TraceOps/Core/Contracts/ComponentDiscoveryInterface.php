<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Contracts;

use App\Libraries\TraceOps\UI\BaseComponent;

interface ComponentDiscoveryInterface
{
    /**
     * @return list<class-string<BaseComponent>>
     */
    public function discover(string $directory, string $namespace): array;
}
