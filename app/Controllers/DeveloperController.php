<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Libraries\TraceOps\UI\ComponentRegistry;
use App\Libraries\TraceOps\UI\Components\ButtonComponent;

final class DeveloperController extends BaseController
{
    public function index(): string
    {
        $registry = new ComponentRegistry([
            ButtonComponent::class,
        ]);

        $descriptors = $registry->descriptors();
        $slotCount = 0;
        $propertyCount = 0;
        $capabilityCount = 0;

        foreach ($descriptors as $descriptor) {
            $data = $descriptor->toArray();
            $slotCount += count($data['slots'] ?? []);
            $propertyCount += count($data['properties'] ?? []);
            $capabilityCount += count($data['capabilities'] ?? []);
        }

        return view('developer/index', array_merge($this->viewData, [
            'title' => 'Developer Console',
            'runtimeVersion' => $this->traceOps->version,
            'descriptors' => $descriptors,
            'runtimeStats' => [
                'components' => $registry->count(),
                'descriptors' => count($descriptors),
                'properties' => $propertyCount,
                'slots' => $slotCount,
                'capabilities' => $capabilityCount,
            ],
            'runtimeHealth' => [
                'Framework Core' => true,
                'Universal Composition' => true,
                'Named Slots' => true,
                'Descriptor Engine' => true,
            ],
        ]));
    }
}
