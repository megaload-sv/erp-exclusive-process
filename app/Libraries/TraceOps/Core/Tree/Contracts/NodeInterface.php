<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Tree\Contracts;

use App\Libraries\TraceOps\Core\Tree\NodeCollection;
use App\Libraries\TraceOps\Core\Tree\SlotCollection;

interface NodeInterface
{
    public function nodeName(): string;

    public function addChild(NodeInterface $child): static;

    public function removeChild(NodeInterface $child): static;

    public function children(): NodeCollection;

    public function setSlot(string $name, NodeInterface ...$nodes): static;

    public function addToSlot(string $name, NodeInterface $node): static;

    public function removeFromSlot(string $name, NodeInterface $node): static;

    public function clearSlot(string $name): static;

    public function slot(string $name): NodeCollection;

    public function slots(): SlotCollection;

    public function parent(): ?NodeInterface;

    public function root(): NodeInterface;

    public function depth(): int;

    /**
     * @return list<string>
     */
    public function path(): array;
}
