<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Tree;

use App\Libraries\TraceOps\Core\Tree\Contracts\NodeInterface;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, NodeInterface>
 */
final class NodeCollection implements Countable, IteratorAggregate
{
    /**
     * @var list<NodeInterface>
     */
    private array $nodes = [];

    /**
     * @param iterable<NodeInterface> $nodes
     */
    public function __construct(iterable $nodes = [])
    {
        foreach ($nodes as $node) {
            $this->add($node);
        }
    }

    public function add(NodeInterface $node): self
    {
        if (! $this->contains($node)) {
            $this->nodes[] = $node;
        }

        return $this;
    }

    public function remove(NodeInterface $node): self
    {
        $this->nodes = array_values(array_filter(
            $this->nodes,
            static fn (NodeInterface $candidate): bool => $candidate !== $node
        ));

        return $this;
    }

    public function contains(NodeInterface $node): bool
    {
        foreach ($this->nodes as $candidate) {
            if ($candidate === $node) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return list<NodeInterface>
     */
    public function all(): array
    {
        return $this->nodes;
    }

    public function count(): int
    {
        return count($this->nodes);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->nodes);
    }
}