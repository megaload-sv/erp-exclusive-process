<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Libraries\TraceOps\Core\Capabilities\BehaviorResolver;
use App\Libraries\TraceOps\Core\Capabilities\CapabilityRegistry;
use App\Libraries\TraceOps\Core\Capabilities\ClickableCapability;
use App\Libraries\TraceOps\Core\Capabilities\DisableableCapability;
use App\Libraries\TraceOps\Core\Capabilities\FocusableCapability;
use App\Libraries\TraceOps\Core\Capabilities\RenderableCapability;
use App\Libraries\TraceOps\Core\Metadata\MetadataRegistry;
use App\Libraries\TraceOps\Core\Metadata\SemanticMetadata;
use App\Libraries\TraceOps\Core\Types\BooleanType;
use App\Libraries\TraceOps\Core\Types\EmailType;
use App\Libraries\TraceOps\Core\Types\StringType;
use App\Libraries\TraceOps\Core\Types\TypeRegistry;
use App\Libraries\TraceOps\Core\Types\UuidType;
use App\Libraries\TraceOps\UI\ComponentRegistry;
use App\Libraries\TraceOps\UI\Components\ButtonComponent;

final class DeveloperController extends BaseController
{
    public function index(): string
    {
        $componentRegistry = new ComponentRegistry([ButtonComponent::class]);
        $capabilityRegistry = new CapabilityRegistry([
            RenderableCapability::class,
            ClickableCapability::class,
            FocusableCapability::class,
            DisableableCapability::class,
        ]);
        $typeRegistry = new TypeRegistry([
            StringType::class,
            BooleanType::class,
            EmailType::class,
            UuidType::class,
        ]);
        $metadataRegistry = new MetadataRegistry([
            'component.button' => SemanticMetadata::make()
                ->title('Button')
                ->summary('Semantic action component')
                ->category('components')
                ->tags('ui', 'action')
                ->since('0.3.0'),
            'property.button.label' => SemanticMetadata::make()
                ->title('Button label')
                ->group('Content')
                ->placeholder('Guardar cambios')
                ->example('Guardar'),
        ]);

        $descriptors = $componentRegistry->descriptors();
        $resolver = new BehaviorResolver($capabilityRegistry);
        $slotCount = 0;
        $propertyCount = 0;
        $capabilityCount = 0;

        foreach ($descriptors as $descriptor) {
            $data = $descriptor->toArray();
            $slotCount += count($data['slots'] ?? []);
            $propertyCount += count($data['properties'] ?? []);
            $capabilityCount += count($descriptor->capabilities());
        }

        $capabilityCatalog = array_map(
            static function (array $capability) use ($resolver, $descriptors): array {
                $capability['components'] = array_map(
                    static fn ($descriptor): string => $descriptor->type(),
                    $resolver->componentsSupporting($descriptors, $capability['name'])
                );
                return $capability;
            },
            $capabilityRegistry->catalog()
        );

        return view('developer/index', array_merge($this->viewData, [
            'title' => 'Developer Console',
            'runtimeVersion' => $this->traceOps->version,
            'descriptors' => $descriptors,
            'capabilityCatalog' => $capabilityCatalog,
            'typeCatalog' => $typeRegistry->descriptors(),
            'metadataCatalog' => $metadataRegistry->catalog(),
            'runtimeStats' => [
                'components' => $componentRegistry->count(),
                'descriptors' => count($descriptors),
                'properties' => $propertyCount,
                'slots' => $slotCount,
                'capabilities' => $capabilityRegistry->count(),
                'assignments' => $capabilityCount,
                'types' => count($typeRegistry->all()),
                'metadata' => $metadataRegistry->count(),
            ],
            'runtimeHealth' => [
                'Framework Core' => true,
                'Universal Composition' => true,
                'Named Slots' => true,
                'Descriptor Engine' => true,
                'Capability Engine' => true,
                'Semantic Type System' => true,
                'Semantic Metadata Model' => true,
            ],
        ]));
    }
}