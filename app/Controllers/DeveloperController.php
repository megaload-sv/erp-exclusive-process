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
use App\Libraries\TraceOps\Core\Runtime\RuntimeKernelBuilder;
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
        $kernel = (new RuntimeKernelBuilder())->build(
            new ComponentRegistry([ButtonComponent::class]),
            new CapabilityRegistry([
                RenderableCapability::class,
                ClickableCapability::class,
                FocusableCapability::class,
                DisableableCapability::class,
            ]),
            new TypeRegistry([
                StringType::class,
                BooleanType::class,
                EmailType::class,
                UuidType::class,
            ]),
            new MetadataRegistry([
                'component.button' => SemanticMetadata::make()
                    ->title('Button')->summary('Semantic action component')
                    ->category('components')->tags('ui', 'action')->since('0.3.0'),
                'property.button.label' => SemanticMetadata::make()
                    ->title('Button label')->group('Content')
                    ->placeholder('Guardar cambios')->example('Guardar'),
            ]),
        );

        $descriptors = $kernel->components()->descriptors();
        $resolver = new BehaviorResolver($kernel->capabilities());
        $capabilityCatalog = array_map(
            static function (array $capability) use ($resolver, $descriptors): array {
                $capability['components'] = array_map(
                    static fn ($descriptor): string => $descriptor->type(),
                    $resolver->componentsSupporting($descriptors, $capability['name'])
                );
                return $capability;
            },
            $kernel->capabilities()->catalog()
        );

        return view('developer/index', array_merge($this->viewData, [
            'title' => 'Developer Console',
            'runtimeVersion' => $this->traceOps->version,
            'kernelClass' => $kernel::class,
            'descriptors' => $descriptors,
            'capabilityCatalog' => $capabilityCatalog,
            'typeCatalog' => $kernel->types()->descriptors(),
            'metadataCatalog' => $kernel->metadata()->catalog(),
            'relationshipCatalog' => $kernel->relationships()->catalog(),
            'knowledgeCatalog' => $kernel->knowledge()->catalog(),
            'knowledgeSummary' => $kernel->knowledge()->summary(),
            'runtimeStats' => $kernel->stats(),
            'runtimeHealth' => $kernel->health(),
        ]));
    }
}
