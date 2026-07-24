<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\Core;

use App\Libraries\TraceOps\Core\ComponentManager;
use App\Libraries\TraceOps\UI\Components\ButtonComponent;
use PHPUnit\Framework\TestCase;

final class ComponentManagerTest extends TestCase
{
    public function testItProvidesTheCompleteRegistrationAndCreationWorkflow(): void
    {
        $manager = new ComponentManager();
        $manager->register(ButtonComponent::class);

        $button = $manager->make('button', ['label' => 'Procesar']);

        self::assertTrue($manager->has('button'));
        self::assertSame(ButtonComponent::class, $manager->all()['button']);
        self::assertSame('Procesar', $button->props()['label']);
        self::assertSame('actions', $manager->metadata()['button']['category']);
    }

    public function testItDiscoversRegistersAndCreatesComponentsAutomatically(): void
    {
        $directory = dirname(__DIR__, 4) . '/app/Libraries/TraceOps/UI/Components';

        $manager = (new ComponentManager())->discover(
            $directory,
            'App\\Libraries\\TraceOps\\UI\\Components'
        );

        $button = $manager->make('button', ['label' => 'Guardar']);

        self::assertTrue($manager->has('button'));
        self::assertInstanceOf(ButtonComponent::class, $button);
        self::assertSame('Guardar', $button->props()['label']);
    }
}
