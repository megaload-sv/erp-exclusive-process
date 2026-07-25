<?php

declare(strict_types=1);

namespace App\Services\Studio;

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

final class ExplorerService
{
    /**
     * Builds the public view model consumed by TraceOps Studio Explorer.
     *
     * @return array<string, mixed>
     */
    public function build(): array
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
        $metadataCatalog = $kernel->metadata()->catalog();
        $relationships = $kernel->relationships()->catalog();

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

        $components = array_map(
            static function ($descriptor) use ($metadataCatalog, $relationships): array {
                $component = $descriptor->toArray();
                $type = (string) $component['type'];
                $identity = 'component.' . $type;
                $componentMetadata = $metadataCatalog[$identity] ?? [];

                return [
                    ...$component,
                    'identity' => $identity,
                    'title' => $componentMetadata['title'] ?? $component['displayName'] ?? ucfirst($type),
                    'summary' => $componentMetadata['summary'] ?? 'Runtime component.',
                    'version' => $componentMetadata['since'] ?? null,
                    'tags' => $componentMetadata['tags'] ?? [],
                    'relationships' => array_values(array_filter(
                        $relationships,
                        static fn (array $relationship): bool =>
                            ($relationship['source'] ?? null) === $identity
                            || ($relationship['source'] ?? null) === $type
                    )),
                    'preview' => [
                        'view' => $component['view'] ?? null,
                        'data' => self::previewData($type),
                    ],
                    'searchText' => strtolower(implode(' ', [
                        $type,
                        $componentMetadata['title'] ?? '',
                        $componentMetadata['summary'] ?? '',
                        implode(' ', $component['capabilities'] ?? []),
                        implode(' ', $componentMetadata['tags'] ?? []),
                        implode(' ', array_map(
                            static fn (array $property): string => implode(' ', [
                                $property['name'] ?? '',
                                $property['label'] ?? '',
                                $property['type'] ?? '',
                            ]),
                            $component['properties'] ?? []
                        )),
                    ])),
                ];
            },
            $descriptors
        );

        return [
            'kernelClass' => $kernel::class,
            'components' => $components,
            'capabilityCatalog' => $capabilityCatalog,
            'typeCatalog' => $kernel->types()->descriptors(),
            'metadataCatalog' => $metadataCatalog,
            'relationshipCatalog' => $relationships,
            'knowledgeCatalog' => $kernel->knowledge()->catalog(),
            'knowledgeSummary' => $kernel->knowledge()->summary(),
            'runtimeStats' => $kernel->stats(),
            'runtimeHealth' => $kernel->health(),
            'filters' => [
                'categories' => self::uniqueValues($components, 'category'),
                'capabilities' => self::nestedUniqueValues($components, 'capabilities'),
                'types' => self::propertyTypes($components),
            ],
        ];
    }

    /** @return array<string, mixed> */
    private static function previewData(string $type): array
    {
        return match ($type) {
            'button' => [
                'label' => 'Guardar cambios',
                'variant' => 'primary',
                'type' => 'button',
            ],
            default => [],
        };
    }

    /** @param array<int, array<string, mixed>> $items */
    private static function uniqueValues(array $items, string $key): array
    {
        $values = array_filter(array_map(
            static fn (array $item): ?string => isset($item[$key]) ? (string) $item[$key] : null,
            $items
        ));
        $values = array_values(array_unique($values));
        sort($values);

        return $values;
    }

    /** @param array<int, array<string, mixed>> $items */
    private static function nestedUniqueValues(array $items, string $key): array
    {
        $values = [];
        foreach ($items as $item) {
            foreach (($item[$key] ?? []) as $value) {
                $values[] = (string) $value;
            }
        }
        $values = array_values(array_unique($values));
        sort($values);

        return $values;
    }

    /** @param array<int, array<string, mixed>> $components */
    private static function propertyTypes(array $components): array
    {
        $types = [];
        foreach ($components as $component) {
            foreach (($component['properties'] ?? []) as $property) {
                if (isset($property['type'])) {
                    $types[] = (string) $property['type'];
                }
            }
        }
        $types = array_values(array_unique($types));
        sort($types);

        return $types;
    }
}
