<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core\Runtime\Services;

use App\Libraries\TraceOps\Core\Runtime\Navigation\RuntimeComponent;
use App\Libraries\TraceOps\Core\Runtime\Services\Contracts\InspectorInterface;

final class RuntimeInspector implements InspectorInterface
{
    public function __construct(
        private readonly RuntimeComponent $component,
    ) {
    }

    /** @return array<string, mixed> */
    public function describe(): array
    {
        return [
            'general' => $this->general(),
            'properties' => $this->properties(),
            'capabilities' => $this->component->capabilities(),
            'metadata' => $this->component->metadata(),
            'relationships' => $this->component->relationships(),
            'knowledge' => $this->component->knowledge(),
            'preview' => $this->component->preview(),
            'diagnostics' => $this->diagnostics(),
        ];
    }

    /** @return array<string, mixed> */
    public function general(): array
    {
        return [
            'identity' => $this->component->identity(),
            'kind' => $this->component->kind(),
            'type' => $this->component->type(),
            'title' => $this->component->title(),
            'summary' => $this->component->summary(),
        ];
    }

    /** @return list<array<string, mixed>> */
    public function properties(): array
    {
        return $this->component->properties();
    }

    /** @return array<string, mixed> */
    public function diagnostics(): array
    {
        return [
            'hasMetadata' => $this->component->metadata() !== [],
            'hasKnowledge' => $this->component->knowledge() !== null,
            'hasPreview' => ($this->component->preview()['view'] ?? null) !== null,
            'propertyCount' => count($this->component->properties()),
            'capabilityCount' => count($this->component->capabilities()),
            'relationshipCount' => count($this->component->relationships()),
        ];
    }
}
