<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\UI\Components;

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

    /**
     * @return array<string, array<string, mixed>>
     */
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

    /**
     * @return array<string, mixed>
     */
    public static function metadata(): array
    {
        return array_merge(parent::metadata(), [
            'category' => 'actions',
            'description' => 'Enterprise action button with link and loading support.',
            'version' => '1.0.0',
        ]);
    }
}
