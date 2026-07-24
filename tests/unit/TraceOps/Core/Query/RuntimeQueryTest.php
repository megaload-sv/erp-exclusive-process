<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\Core\Query;

use App\Libraries\TraceOps\Core\Capabilities\CapabilityRegistry;
use App\Libraries\TraceOps\Core\Capabilities\ClickableCapability;
use App\Libraries\TraceOps\Core\Metadata\MetadataRegistry;
use App\Libraries\TraceOps\Core\Runtime\RuntimeKernelBuilder;
use App\Libraries\TraceOps\Core\Types\StringType;
use App\Libraries\TraceOps\Core\Types\TypeRegistry;
use App\Libraries\TraceOps\UI\ComponentRegistry;
use App\Libraries\TraceOps\UI\Components\ButtonComponent;
use CodeIgniter\Test\CIUnitTestCase;

final class RuntimeQueryTest extends CIUnitTestCase
{
    public function testItSelectsSemanticEntityKindsThroughTheKernel(): void
    {
        $kernel = $this->kernel();

        self::assertSame('component.button', $kernel->query()->components()->first()?->identity());
        self::assertSame('type.string', $kernel->query()->types()->first()?->identity());
        self::assertGreaterThan(0, $kernel->query()->properties()->count());
    }

    public function testItFiltersByIdentityNameAndAttributes(): void
    {
        $kernel = $this->kernel();

        self::assertSame(
            'component.button',
            $kernel->query()->components()->whereIdentity('component.button')->first()?->identity(),
        );

        self::assertSame(
            'button',
            $kernel->query()->components()->whereName('button')->first()?->name(),
        );

        self::assertSame(
            'component.button',
            $kernel->query()->components()->whereAttribute('type', 'button')->first()?->identity(),
        );
    }

    public function testItUsesGraphRelationshipsForSemanticFilters(): void
    {
        $kernel = $this->kernel();

        self::assertSame(
            'component.button',
            $kernel->query()->components()->supporting('clickable')->first()?->identity(),
        );

        self::assertSame(
            'component.button',
            $kernel->query()->components()->havingProperty('label')->first()?->identity(),
        );
    }

    public function testItOrdersLimitsAndProjectsResults(): void
    {
        $result = $this->kernel()
            ->query()
            ->entities()
            ->orderBy('identity')
            ->limit(2)
            ->get();

        self::assertCount(2, $result);
        self::assertCount(2, $result->catalog());
        self::assertFalse($result->isEmpty());
    }

    private function kernel(): \App\Libraries\TraceOps\Core\Runtime\Contracts\RuntimeKernelInterface
    {
        return (new RuntimeKernelBuilder())->build(
            new ComponentRegistry([ButtonComponent::class]),
            new CapabilityRegistry([ClickableCapability::class]),
            new TypeRegistry([StringType::class]),
            new MetadataRegistry(),
        );
    }
}
