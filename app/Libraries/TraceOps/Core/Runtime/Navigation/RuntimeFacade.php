<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Runtime\Navigation;

use App\Libraries\TraceOps\Core\Runtime\Contracts\RuntimeKernelInterface;
use InvalidArgumentException;

final class RuntimeFacade
{
    public function __construct(
        private readonly RuntimeKernelInterface $kernel,
    ) {
    }

    public static function fromKernel(RuntimeKernelInterface $kernel): self
    {
        return new self($kernel);
    }

    /** @return list<RuntimeComponent> */
    public function components(): array
    {
        return array_values(array_map(
            fn ($descriptor): RuntimeComponent => new RuntimeComponent($this->kernel, $descriptor),
            $this->kernel->components()->descriptors()
        ));
    }

    public function component(string $type): RuntimeComponent
    {
        $descriptors = $this->kernel->components()->descriptors();

        if (! isset($descriptors[$type])) {
            throw new InvalidArgumentException("Runtime component [{$type}] is not registered.");
        }

        return new RuntimeComponent($this->kernel, $descriptors[$type]);
    }

    /** @return list<RuntimeType> */
    public function types(): array
    {
        return array_values(array_map(
            fn (array $descriptor, string $name): RuntimeType => new RuntimeType($this->kernel, $name, $descriptor),
            $this->kernel->types()->descriptors(),
            array_keys($this->kernel->types()->descriptors())
        ));
    }

    public function type(string $name): RuntimeType
    {
        $descriptors = $this->kernel->types()->descriptors();
        $normalized = strtolower(trim($name));

        if (! isset($descriptors[$normalized])) {
            throw new InvalidArgumentException("Runtime type [{$name}] is not registered.");
        }

        return new RuntimeType($this->kernel, $normalized, $descriptors[$normalized]);
    }

    /** @return list<RuntimeCapability> */
    public function capabilities(): array
    {
        return array_map(
            fn (array $descriptor): RuntimeCapability => new RuntimeCapability(
                $this->kernel,
                (string) $descriptor['name'],
                $descriptor
            ),
            $this->kernel->capabilities()->catalog()
        );
    }

    public function capability(string $name): RuntimeCapability
    {
        foreach ($this->kernel->capabilities()->catalog() as $descriptor) {
            if (($descriptor['name'] ?? null) === $name) {
                return new RuntimeCapability($this->kernel, $name, $descriptor);
            }
        }

        throw new InvalidArgumentException("Runtime capability [{$name}] is not registered.");
    }

    /** @return list<SemanticObject> */
    public function objects(): array
    {
        return [
            ...$this->components(),
            ...$this->types(),
            ...$this->capabilities(),
        ];
    }

    /** @return list<array<string, mixed>> */
    public function knowledge(): array
    {
        return $this->kernel->knowledge()->catalog();
    }

    /** @return array<string, int> */
    public function stats(): array
    {
        return $this->kernel->stats();
    }

    /** @return array<string, bool> */
    public function health(): array
    {
        return $this->kernel->health();
    }

    public function kernel(): RuntimeKernelInterface
    {
        return $this->kernel;
    }
}
