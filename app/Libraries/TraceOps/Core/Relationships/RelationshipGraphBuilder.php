<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Relationships;

use App\Libraries\TraceOps\Core\Metadata\ComponentDescriptor;

final class RelationshipGraphBuilder
{
    /** @param iterable<ComponentDescriptor> $descriptors */
    public function build(iterable $descriptors): RelationshipRegistry
    {
        $registry = new RelationshipRegistry();

        foreach ($descriptors as $descriptor) {
            $component = 'component.' . $descriptor->type();

            foreach ($descriptor->properties() as $property) {
                $propertyId = sprintf('property.%s.%s', $descriptor->type(), $property->name());
                $registry->register(Relationship::make($component, 'hasProperty', $propertyId));
                $registry->register(Relationship::make($propertyId, 'hasType', 'type.' . $property->type()));

                if ($property->metadata() !== []) {
                    $registry->register(Relationship::make($propertyId, 'describedBy', 'metadata.' . $propertyId));
                }
            }

            foreach ($descriptor->capabilities() as $capability) {
                $registry->register(Relationship::make($component, 'supports', 'capability.' . $capability));
            }

            foreach (($descriptor->toArray()['slots'] ?? []) as $slot) {
                $registry->register(Relationship::make($component, 'hasSlot', sprintf('slot.%s.%s', $descriptor->type(), $slot)));
            }
        }

        return $registry;
    }
}
