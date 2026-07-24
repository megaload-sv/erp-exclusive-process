<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\Core\Runtime;

use App\Libraries\TraceOps\Core\Capabilities\CapabilityRegistry;
use App\Libraries\TraceOps\Core\Capabilities\ClickableCapability;
use App\Libraries\TraceOps\Core\Metadata\MetadataRegistry;
use App\Libraries\TraceOps\Core\Runtime\Contracts\RuntimeKernelInterface;
use App\Libraries\TraceOps\Core\Runtime\RuntimeKernelBuilder;
use App\Libraries\TraceOps\Core\Types\StringType;
use App\Libraries\TraceOps\Core\Types\TypeRegistry;
use App\Libraries\TraceOps\UI\ComponentRegistry;
use App\Libraries\TraceOps\UI\Components\ButtonComponent;
use CodeIgniter\Test\CIUnitTestCase;

final class RuntimeKernelTest extends CIUnitTestCase
{
    public function testItExposesRuntimeRegistriesThroughOneContract(): void
    {
        $kernel = (new RuntimeKernelBuilder())->build(
            new ComponentRegistry([ButtonComponent::class]),
            new CapabilityRegistry([ClickableCapability::class]),
            new TypeRegistry([StringType::class]),
            new MetadataRegistry(),
        );

        self::assertInstanceOf(RuntimeKernelInterface::class, $kernel);
        self::assertTrue($kernel->components()->has('button'));
        self::assertTrue($kernel->capabilities()->has('clickable'));
        self::assertTrue($kernel->types()->has('string'));
        self::assertTrue($kernel->knowledge()->has('component.button'));
        self::assertGreaterThan(0, $kernel->relationships()->count());
    }

    public function testItProducesRuntimeDiagnostics(): void
    {
        $kernel = (new RuntimeKernelBuilder())->build(
            new ComponentRegistry([ButtonComponent::class]),
            new CapabilityRegistry([ClickableCapability::class]),
            new TypeRegistry([StringType::class]),
            new MetadataRegistry(),
        );

        self::assertSame(1, $kernel->stats()['components']);
        self::assertArrayHasKey('knowledge', $kernel->stats());
        self::assertTrue($kernel->health()['Runtime Kernel']);
    }
}
