<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Contracts;

use App\Libraries\TraceOps\Core\Tree\NodeInterface;

interface VisitorInterface
{
    public function visit(NodeInterface $node): void;
}
