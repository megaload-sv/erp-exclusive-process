<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Tree;

use App\Libraries\TraceOps\Core\Tree\Contracts\NodeInterface;
use InvalidArgumentException;

abstract class AbstractNode implements NodeInterface
{
    private NodeCollection $children;

    private SlotCollection $slots;

    private ?NodeInterface $parent = null;

    public function __construct()
    {
        $this->children = new NodeCollection();
        $this->slots = new SlotCollection();
    }

    public function addChild(NodeInterface $child): static
    {
        $this->attach($child);
        $this->children->add($child);

        return $this;
    }

    public function removeChild(NodeInterface $child): static
    {
        $this->children->remove($child);
        $this->clearParentWhenDetached($child);

        return $this;
    }

    public function children(): NodeCollection
    {
        return $this->children;
    }

    public function setSlot(string $name, NodeInterface ...$nodes): static
    {
        $this->clearSlot($name);

        foreach ($nodes as $node) {
            $this->addToSlot($name, $node);
        }

        return $this;
    }

    public function addToSlot(string $name, NodeInterface $node): static
    {
        $this->attach($node);
        $this->slots->add($name, $node);

        return $this;
    }

    public function removeFromSlot(string $name, NodeInterface $node): static
    {
        $this->slots->remove($name, $node);
        $this->clearParentWhenDetached($node);

        return $this;
    }

    public function clearSlot(string $name): static
    {
        foreach ($this->slots->get($name) as $node) {
            $this->clearParentWhenDetached($node);
        }

        $this->slots->clear($name);

        return $this;
    }

    public function slot(string $name): NodeCollection
    {
        return $this->slots->get($name);
    }

    public function slots(): SlotCollection
    {
        return $this->slots;
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

    private function attach(NodeInterface $node): void
    {
        if ($node === $this || $this->isDescendantOf($node)) {
            throw new InvalidArgumentException('A node cannot contain itself or one of its ancestors.');
        }

        if ($node instanceof self) {
            $node->detachFromParent();
            $node->parent = $this;
        }
    }

    private function detachFromParent(): void
    {
        if ($this->parent instanceof self) {
            $this->parent->detachNodeReference($this);
        }
    }

    private function detachNodeReference(NodeInterface $node): void
    {
        $this->children->remove($node);

        foreach ($this->slots->names() as $slotName) {
            $this->slots->remove($slotName, $node);
        }

        $this->clearParentWhenDetached($node);
    }

    private function clearParentWhenDetached(NodeInterface $node): void
    {
        if ($node instanceof self && $node->parent === $this) {
            $node->parent = null;
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
