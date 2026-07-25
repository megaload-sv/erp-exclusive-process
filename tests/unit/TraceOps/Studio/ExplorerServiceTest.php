<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\Studio;

use App\Services\Studio\ExplorerService;
use CodeIgniter\Test\CIUnitTestCase;

final class ExplorerServiceTest extends CIUnitTestCase
{
    public function testItBuildsDescriptorDrivenComponentCards(): void
    {
        $model = (new ExplorerService())->build();

        self::assertNotEmpty($model['components']);
        self::assertSame('component.button', $model['components'][0]['identity']);
        self::assertSame('Button', $model['components'][0]['title']);
        self::assertContains('clickable', $model['components'][0]['capabilities']);
        self::assertSame('Guardar cambios', $model['components'][0]['preview']['data']['label']);
    }

    public function testItBuildsSemanticFiltersFromRuntimeDescriptors(): void
    {
        $model = (new ExplorerService())->build();

        self::assertContains('clickable', $model['filters']['capabilities']);
        self::assertNotEmpty($model['filters']['types']);
        self::assertArrayHasKey('runtimeStats', $model);
        self::assertArrayHasKey('runtimeHealth', $model);
    }
}
