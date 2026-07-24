<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Knowledge;

use App\Libraries\TraceOps\Core\Capabilities\CapabilityRegistry;
use App\Libraries\TraceOps\Core\Metadata\ComponentDescriptor;
use App\Libraries\TraceOps\Core\Metadata\MetadataRegistry;
use App\Libraries\TraceOps\Core\Relationships\RelationshipGraphBuilder;
use App\Libraries\TraceOps\Core\Types\TypeRegistry;

final class KnowledgeRegistryBuilder
{
    /** @param iterable<ComponentDescriptor> $descriptors */
    public function build(
        iterable $descriptors,
        CapabilityRegistry $capabilities,
        TypeRegistry $types,
        MetadataRegistry $metadata,
    ): KnowledgeRegistry {
        $descriptorList = is_array($descriptors) ? $descriptors : iterator_to_array($descriptors);
        $relationships = (new RelationshipGraphBuilder())->build($descriptorList);
        $knowledge = new KnowledgeRegistry([], $relationships);

        foreach ($descriptorList as $descriptor) {
            $componentIdentity = 'component.' . $descriptor->type();
            $componentData = $descriptor->toArray();

            $knowledge->register(SemanticEntity::make(
                $componentIdentity,
                'component',
                $descriptor->type(),
                $componentData
            ));

            foreach ($descriptor->properties() as $property) {
                $propertyIdentity = sprintf('property.%s.%s', $descriptor->type(), $property->name());
                $knowledge->register(SemanticEntity::make(
                    $propertyIdentity,
                    'property',
                    $property->name(),
                    $property->toArray()
                ));
            }

            foreach (($componentData['slots'] ?? []) as $slot) {
                $knowledge->register(SemanticEntity::make(
                    sprintf('slot.%s.%s', $descriptor->type(), $slot),
                    'slot',
                    (string) $slot,
                    ['component' => $descriptor->type()]
                ));
            }
        }

        foreach ($types->descriptors() as $name => $descriptor) {
            $knowledge->register(SemanticEntity::make('type.' . $name, 'type', $name, $descriptor));
        }

        foreach ($capabilities->catalog() as $capability) {
            $knowledge->register(SemanticEntity::make(
                'capability.' . $capability['name'],
                'capability',
                $capability['name'],
                $capability
            ));
        }

        foreach ($metadata->catalog() as $identity => $entry) {
            $knowledge->register(SemanticEntity::make(
                'metadata.' . $identity,
                'metadata',
                $identity,
                $entry
            ));
        }

        return $knowledge;
    }
}
