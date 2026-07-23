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
}