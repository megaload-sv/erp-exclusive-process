<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Runtime;

use App\Libraries\TraceOps\Core\Capabilities\CapabilityRegistry;
use App\Libraries\TraceOps\Core\Knowledge\KnowledgeRegistryBuilder;
use App\Libraries\TraceOps\Core\Metadata\MetadataRegistry;
use App\Libraries\TraceOps\Core\Types\TypeRegistry;
use App\Libraries\TraceOps\UI\ComponentRegistry;

final class RuntimeKernelBuilder
{
    public function build(
        ComponentRegistry $components,
        CapabilityRegistry $capabilities,
        TypeRegistry $types,
        MetadataRegistry $metadata,
    ): RuntimeKernel {
        $knowledge = (new KnowledgeRegistryBuilder())->build(
            $components->descriptors(),
            $capabilities,
            $types,
            $metadata,
        );

        return new RuntimeKernel(
            $components,
            $capabilities,
            $types,
            $metadata,
            $knowledge,
        );
    }
}
