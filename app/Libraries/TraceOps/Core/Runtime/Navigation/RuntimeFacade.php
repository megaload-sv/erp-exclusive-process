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

    /** @return array<string, mixed> */
    public function capabilities(): array
    {
        return $this->kernel->capabilities()->catalog();
    }

    /** @return array<string, mixed> */
    public function types(): array
    {
        return $this->kernel->types()->descriptors();
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
