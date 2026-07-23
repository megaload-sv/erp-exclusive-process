<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\Core;

use App\Libraries\TraceOps\Core\ComponentDiscovery;
use App\Libraries\TraceOps\UI\Components\ButtonComponent;
use PHPUnit\Framework\TestCase;

final class ComponentDiscoveryTest extends TestCase
{
    public function testItDiscoversConcreteComponentsFromDirectoryAndNamespace(): void
    {
        $directory = dirname(__DIR__, 4) . '/app/Libraries/TraceOps/UI/Components';

        $components = (new ComponentDiscovery())->discover(
            $directory,
            'App\\Libraries\\TraceOps\\UI\\Components'
        );

        self::assertContains(ButtonComponent::class, $components);
    }

    public function testItReturnsAnEmptyCollectionForMissingDirectory(): void
    {
        $components = (new ComponentDiscovery())->discover(
            dirname(__DIR__, 4) . '/missing-components',
            'App\\Missing\\Components'
        );

        self::assertSame([], $components);
    }
}
