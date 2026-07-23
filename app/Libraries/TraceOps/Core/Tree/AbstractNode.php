<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Tree;

use App\Libraries\TraceOps\Core\Tree\Contracts\NodeInterface;
use InvalidArgumentException;

abstract class AbstractNode implements NodeInterface
{
    private NodeCollection $children;

    private ?NodeInterface $parent = null;

    public function __construct()
    {
        $this->children = new NodeCollection();
    }

    public function addChild(NodeInterface $child): static
    {
        if ($child === $this || $this->isDescendantOf($child)) {
            throw new InvalidArgumentException('A node cannot contain itself or one of its ancestors.');
        }

        if ($child instanceof self) {
            $child->detachFromParent();
            $child->parent = $this;
        }

        $this->children->add($child);

        return $this;
    }

    public function removeChild(NodeInterface $child): static
    {
        $this->children->remove($child);

        if ($child instanceof self && $child->parent === $this) {
            $child->parent = null;
        }

        return $this;
    }

    public function children(): NodeCollection
    {
        return $this->children;
    }

    public function parent(): ?NodeInterface
    {
        return $this->parent;
    }

    public function root(): NodeInterface
    {
        $node = $this;

        while ($node->parent() !== null) {
            $node = $node->parent();
        }

        return $node;
    }

    public function depth(): int
    {
        $depth = 0;
        $node = $this;

        while ($node->parent() !== null) {
            $depth++;
            $node = $node->parent();
        }

        return $depth;
    }

    public function path(): array
    {
        $path = [$this->nodeName()];
        $node = $this;

        while ($node->parent() !== null) {
            $node = $node->parent();
            array_unshift($path, $node->nodeName());
        }

        return $path;
    }

    private function detachFromParent(): void
    {
        if ($this->parent !== null) {
            $this->parent->removeChild($this);
        }
    }

    private function isDescendantOf(NodeInterface $candidate): bool
    {
        $node = $this->parent;

        while ($node !== null) {
            if ($node === $candidate) {
                return true;
            }

            $node = $node->parent();
        }

        return false;
    }
}