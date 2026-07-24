<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Runtime\Contracts;

use App\Libraries\TraceOps\Core\Capabilities\CapabilityRegistry;
use App\Libraries\TraceOps\Core\Knowledge\KnowledgeRegistry;
use App\Libraries\TraceOps\Core\Metadata\MetadataRegistry;
use App\Libraries\TraceOps\Core\Query\RuntimeQuery;
use App\Libraries\TraceOps\Core\Relationships\RelationshipRegistry;
use App\Libraries\TraceOps\Core\Types\TypeRegistry;
use App\Libraries\TraceOps\UI\ComponentRegistry;

interface RuntimeKernelInterface
{
    public function components(): ComponentRegistry;
    public function capabilities(): CapabilityRegistry;
    public function types(): TypeRegistry;
    public function metadata(): MetadataRegistry;
    public function relationships(): RelationshipRegistry;
    public function knowledge(): KnowledgeRegistry;
    public function query(): RuntimeQuery;

    /** @return array<string, int> */
    public function stats(): array;

    /** @return array<string, bool> */
    public function health(): array;
}
