<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Tree\Contracts;

use App\Libraries\TraceOps\Core\Tree\NodeCollection;

interface NodeInterface
{
    public function nodeName(): string;

    public function addChild(NodeInterface $child): static;

    public function removeChild(NodeInterface $child): static;

    public function children(): NodeCollection;

    public function parent(): ?NodeInterface;

    public function root(): NodeInterface;

    public function depth(): int;

    /**
     * @return list<string>
     */
    public function path(): array;
}