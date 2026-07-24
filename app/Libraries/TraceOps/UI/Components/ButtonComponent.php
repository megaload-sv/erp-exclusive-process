<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\UI\Components;

use App\Libraries\TraceOps\Core\Capabilities\ClickableCapability;
use App\Libraries\TraceOps\Core\Capabilities\DisableableCapability;
use App\Libraries\TraceOps\Core\Capabilities\FocusableCapability;
use App\Libraries\TraceOps\Core\Capabilities\RenderableCapability;
use App\Libraries\TraceOps\UI\BaseComponent;

final class ButtonComponent extends BaseComponent
{
    public static function name(): string
    {
        return 'button';
    }

    public static function view(): string
    {
        return 'components/ui/button';
    }

    public static function category(): ?string
    {
        return 'actions';
    }

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
            'label' => ['type' => 'string', 'default' => 'Acción'],
            'variant' => [
                'type' => 'enum',
                'allowed' => ['primary', 'secondary', 'ghost', 'danger'],
                'default' => 'primary',
            ],
            'href' => ['type' => 'nullable-string'],
            'type' => [
                'type' => 'enum',
                'allowed' => ['button', 'submit', 'reset'],
                'default' => 'button',
            ],
            'disabled' => ['type' => 'bool', 'default' => false],
            'loadingLabel' => ['type' => 'nullable-string'],
            'class' => ['type' => 'string', 'default' => ''],
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
