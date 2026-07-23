<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Tree;

use App\Libraries\TraceOps\Core\Tree\Contracts\NodeInterface;

final class TreeWalker
{
    /**
     * @return list<NodeInterface>
     */
    public function depthFirst(NodeInterface $root): array
    {
        $nodes = [$root];

        foreach ($root->children() as $child) {
            array_push($nodes, ...$this->depthFirst($child));
        }

        return $nodes;
    }

    public function findFirst(NodeInterface $root, callable $predicate): ?NodeInterface
    {
        foreach ($this->depthFirst($root) as $node) {
            if ($predicate($node) === true) {
                return $node;
            }
        }

        return null;
    }

    /**
     * @return list<NodeInterface>
     */
    public function findByName(NodeInterface $root, string $name): array
    {
        return array_values(array_filter(
            $this->depthFirst($root),
            static fn (NodeInterface $node): bool => $node->nodeName() === $name
        ));
    }

    /**
     * @param class-string<NodeInterface> $type
     * @return list<NodeInterface>
     */
    public function findByType(NodeInterface $root, string $type): array
    {
        return array_values(array_filter(
            $this->depthFirst($root),
            static fn (NodeInterface $node): bool => $node instanceof $type
        ));
    }
}