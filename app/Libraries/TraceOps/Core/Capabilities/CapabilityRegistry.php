<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Capabilities;

use App\Libraries\TraceOps\Core\Contracts\CapabilityInterface;
use App\Libraries\TraceOps\Core\Contracts\RegistryInterface;
use InvalidArgumentException;
use OutOfBoundsException;

final class CapabilityRegistry implements RegistryInterface
{
    /** @var array<string, class-string<CapabilityInterface>> */
    private array $capabilities = [];

    /** @param iterable<class-string<CapabilityInterface>> $capabilities */
    public function __construct(iterable $capabilities = [])
    {
        foreach ($capabilities as $capability) {
            $this->register($capability);
        }
    }

    /** @param class-string<CapabilityInterface> $capability */
    public function register(string $capability): void
    {
        if (! is_subclass_of($capability, CapabilityInterface::class)) {
            throw new InvalidArgumentException("{$capability} must implement CapabilityInterface.");
        }

        $name = $capability::name();

        if ($name === '') {
            throw new InvalidArgumentException('Capability names cannot be empty.');
        }

        if (isset($this->capabilities[$name]) && $this->capabilities[$name] !== $capability) {
            throw new InvalidArgumentException("Capability '{$name}' is already registered.");
        }

        $this->capabilities[$name] = $capability;
    }

    public function has(string $name): bool
    {
        return isset($this->capabilities[$name]);
    }

    /** @return class-string<CapabilityInterface> */
    public function get(string $name): string
    {
        if (! $this->has($name)) {
            throw new OutOfBoundsException("Capability '{$name}' is not registered.");
        }

        return $this->capabilities[$name];
    }

    /** @return array<string, class-string<CapabilityInterface>> */
    public function all(): array
    {
        return $this->capabilities;
    }

    /** @return list<array{name: string, class: class-string<CapabilityInterface>, description: ?string}> */
    public function catalog(): array
    {
        return array_values(array_map(
            static fn (string $capability): array => [
                'name' => $capability::name(),
                'class' => $capability,
                'description' => $capability::description(),
            ],
            $this->capabilities
        ));
    }

    public function count(): int
    {
        return count($this->capabilities);
    }
}
