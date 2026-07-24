<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Runtime;

use App\Libraries\TraceOps\Core\Capabilities\CapabilityRegistry;
use App\Libraries\TraceOps\Core\Knowledge\KnowledgeRegistry;
use App\Libraries\TraceOps\Core\Metadata\MetadataRegistry;
use App\Libraries\TraceOps\Core\Relationships\RelationshipRegistry;
use App\Libraries\TraceOps\Core\Runtime\Contracts\RuntimeKernelInterface;
use App\Libraries\TraceOps\Core\Types\TypeRegistry;
use App\Libraries\TraceOps\UI\ComponentRegistry;

final class RuntimeKernel implements RuntimeKernelInterface
{
    public function __construct(
        private readonly ComponentRegistry $components,
        private readonly CapabilityRegistry $capabilities,
        private readonly TypeRegistry $types,
        private readonly MetadataRegistry $metadata,
        private readonly KnowledgeRegistry $knowledge,
    ) {
    }

    public function components(): ComponentRegistry { return $this->components; }
    public function capabilities(): CapabilityRegistry { return $this->capabilities; }
    public function types(): TypeRegistry { return $this->types; }
    public function metadata(): MetadataRegistry { return $this->metadata; }
    public function relationships(): RelationshipRegistry { return $this->knowledge->relationships(); }
    public function knowledge(): KnowledgeRegistry { return $this->knowledge; }

    /** @return array<string, int> */
    public function stats(): array
    {
        $descriptors = $this->components->descriptors();
        $propertyCount = 0;
        $slotCount = 0;
        $assignmentCount = 0;

        foreach ($descriptors as $descriptor) {
            $data = $descriptor->toArray();
            $propertyCount += count($data['properties'] ?? []);
            $slotCount += count($data['slots'] ?? []);
            $assignmentCount += count($descriptor->capabilities());
        }

        return [
            'components' => $this->components->count(),
            'descriptors' => count($descriptors),
            'properties' => $propertyCount,
            'slots' => $slotCount,
            'capabilities' => $this->capabilities->count(),
            'assignments' => $assignmentCount,
            'types' => count($this->types->all()),
            'metadata' => $this->metadata->count(),
            'relationships' => $this->relationships()->count(),
            'knowledge' => $this->knowledge->count(),
        ];
    }

    /** @return array<string, bool> */
    public function health(): array
    {
        return [
            'Framework Core' => true,
            'Universal Composition' => true,
            'Named Slots' => true,
            'Descriptor Engine' => true,
            'Capability Engine' => true,
            'Semantic Type System' => true,
            'Semantic Metadata Model' => true,
            'Relationship Engine' => true,
            'Knowledge Registry' => true,
            'Runtime Kernel' => true,
        ];
    }
}
