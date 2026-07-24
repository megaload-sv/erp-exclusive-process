<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\UI\Components;

use App\Libraries\TraceOps\Core\Capabilities\ClickableCapability;
use App\Libraries\TraceOps\Core\Capabilities\DisableableCapability;
use App\Libraries\TraceOps\Core\Capabilities\FocusableCapability;
use App\Libraries\TraceOps\Core\Capabilities\RenderableCapability;
use App\Libraries\TraceOps\Core\Metadata\SemanticMetadata;
use App\Libraries\TraceOps\Core\Types\BooleanType;
use App\Libraries\TraceOps\Core\Types\StringType;
use App\Libraries\TraceOps\UI\BaseComponent;

final class ButtonComponent extends BaseComponent
{
    public static function name(): string { return 'button'; }
    public static function view(): string { return 'components/ui/button'; }
    public static function category(): ?string { return 'actions'; }

    /** @return list<string> */
    public static function capabilities(): array
    {
        return [
            RenderableCapability::class,
            ClickableCapability::class,
            FocusableCapability::class,
            DisableableCapability::class,
        ];
    }

    /** @return array<string, array<string, mixed>> */
    public static function schema(): array
    {
        return [
            'label' => [
                'type' => StringType::class,
                'label' => 'Label',
                'default' => 'Acción',
                'metadata' => SemanticMetadata::make()
                    ->summary('Visible action text')
                    ->group('Content')
                    ->placeholder('Guardar cambios')
                    ->help('Use a concise verb that describes the action.')
                    ->example('Guardar')
                    ->order(10)
                    ->toArray(),
            ],
            'variant' => [
                'type' => 'enum',
                'allowed' => ['primary', 'secondary', 'ghost', 'danger'],
                'default' => 'primary',
                'metadata' => SemanticMetadata::make()->group('Appearance')->order(20)->toArray(),
            ],
            'href' => [
                'type' => StringType::class,
                'label' => 'Destination URL',
                'metadata' => SemanticMetadata::make()->group('Navigation')->placeholder('/customers')->order(30)->toArray(),
            ],
            'type' => [
                'type' => 'enum',
                'allowed' => ['button', 'submit', 'reset'],
                'default' => 'button',
            ],
            'disabled' => ['type' => BooleanType::class, 'default' => false],
            'loadingLabel' => ['type' => StringType::class],
            'class' => ['type' => StringType::class, 'default' => ''],
        ];
    }

    /** @return array<string, mixed> */
    public static function metadata(): array
    {
        return array_merge(parent::metadata(), [
            'description' => 'Enterprise action button with link and loading support.',
            'version' => '1.0.0',
        ]);
    }
}