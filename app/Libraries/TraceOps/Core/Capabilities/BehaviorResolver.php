<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Capabilities;

use App\Libraries\TraceOps\Core\Metadata\ComponentDescriptor;

final class BehaviorResolver
{
    public function __construct(private readonly CapabilityRegistry $registry)
    {
    }

    public function supports(ComponentDescriptor $descriptor, string $capability): bool
    {
        $name = $this->registry->has($capability)
            ? $capability
            : (is_subclass_of($capability, \App\Libraries\TraceOps\Core\Contracts\CapabilityInterface::class)
                ? $capability::name()
                : $capability);

        return $descriptor->supports($name);
    }

    /** @param iterable<ComponentDescriptor> $descriptors
     *  @return list<ComponentDescriptor>
     */
    public function componentsSupporting(iterable $descriptors, string $capability): array
    {
        $matches = [];

        foreach ($descriptors as $descriptor) {
            if ($this->supports($descriptor, $capability)) {
                $matches[] = $descriptor;
            }
        }

        return $matches;
    }
}
