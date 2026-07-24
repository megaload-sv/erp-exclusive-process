<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\UI;

use App\Libraries\TraceOps\UI\ComponentRegistry;
use App\Libraries\TraceOps\UI\Components\ButtonComponent;
use CodeIgniter\Test\CIUnitTestCase;

final class ComponentRegistryTest extends CIUnitTestCase
{
    public function testItRegistersAndDescribesComponents(): void
    {
        $registry = new ComponentRegistry([ButtonComponent::class]);

        self::assertTrue($registry->has('button'));
        self::assertSame(ButtonComponent::class, $registry->find('button'));
        self::assertSame(1, $registry->count());
        self::assertArrayHasKey('button', $registry->descriptors());
        self::assertSame('button', $registry->descriptors()['button']->type());
    }
}
