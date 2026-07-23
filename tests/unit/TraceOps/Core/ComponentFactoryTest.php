<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\Core;

use App\Libraries\TraceOps\Core\ComponentFactory;
use App\Libraries\TraceOps\Core\ComponentRegistry;
use App\Libraries\TraceOps\UI\Components\ButtonComponent;
use PHPUnit\Framework\TestCase;

final class ComponentFactoryTest extends TestCase
{
    public function testItCreatesARegisteredComponentWithNormalizedProps(): void
    {
        $factory = new ComponentFactory(
            new ComponentRegistry([ButtonComponent::class])
        );

        $component = $factory->make('button', [
            'label' => ' Guardar ',
            'variant' => 'danger',
            'disabled' => 'yes',
            'unknown' => 'ignored',
        ]);

        self::assertInstanceOf(ButtonComponent::class, $component);
        self::assertSame([
            'label' => 'Guardar',
            'variant' => 'danger',
            'href' => null,
            'type' => 'button',
            'disabled' => true,
            'loadingLabel' => null,
            'class' => '',
        ], $component->props());
        self::assertSame($component->props(), $component->toViewData());
    }
}