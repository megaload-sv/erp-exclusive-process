<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Tree;

use App\Libraries\TraceOps\Core\Tree\Contracts\NodeInterface;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<string, NodeCollection>
 */
final class SlotCollection implements Countable, IteratorAggregate
{
    /**
     * @var array<string, NodeCollection>
     */
    private array $slots = [];

    public function set(string $name, NodeInterface ...$nodes): void
    {
        $name = $this->normalizeName($name);
        $collection = new NodeCollection();

        foreach ($nodes as $node) {
            $collection->add($node);
        }

        $this->slots[$name] = $collection;
    }

    public function add(string $name, NodeInterface $node): void
    {
        $this->getOrCreate($name)->add($node);
    }

    public function remove(string $name, NodeInterface $node): void
    {
        $name = $this->normalizeName($name);

        if (! isset($this->slots[$name])) {
            return;
        }

        $this->slots[$name]->remove($node);

        if ($this->slots[$name]->count() === 0) {
            unset($this->slots[$name]);
        }
    }

    public function clear(string $name): void
    {
        unset($this->slots[$this->normalizeName($name)]);
    }

    public function get(string $name): NodeCollection
    {
        $name = $this->normalizeName($name);

        return $this->slots[$name] ?? new NodeCollection();
    }

    public function has(string $name): bool
    {
        return isset($this->slots[$this->normalizeName($name)]);
    }

    /**
     * @return list<string>
     */
    public function names(): array
    {
        return array_keys($this->slots);
    }

    /**
     * @return array<string, NodeCollection>
     */
    public function all(): array
    {
        return $this->slots;
    }

    public function count(): int
    {
        return count($this->slots);
    }

    /**
     * @return Traversable<string, NodeCollection>
     */
    public function getIterator(): Traversable
    {
        yield from $this->slots;
    }

    private function getOrCreate(string $name): NodeCollection
    {
        $name = $this->normalizeName($name);

        return $this->slots[$name] ??= new NodeCollection();
    }

    private function normalizeName(string $name): string
    {
        $name = trim($name);

        if ($name === '' || preg_match('/^[a-z][a-z0-9._-]*$/', $name) !== 1) {
            throw new InvalidArgumentException(sprintf(
                'Invalid slot name [%s]. Slot names must start with a lowercase letter and contain only lowercase letters, numbers, dots, underscores or hyphens.',
                $name
            ));
        }

        return $name;
    }
}
