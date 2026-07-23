<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\Core;

use App\Libraries\TraceOps\Core\ComponentRegistry;
use App\Libraries\TraceOps\Core\Exceptions\ComponentNotFoundException;
use App\Libraries\TraceOps\Core\Exceptions\DuplicateComponentException;
use App\Libraries\TraceOps\Core\Exceptions\InvalidComponentException;
use App\Libraries\TraceOps\UI\Components\ButtonComponent;
use PHPUnit\Framework\TestCase;

final class ComponentRegistryTest extends TestCase
{
    public function testItRegistersAndResolvesComponents(): void
    {
        $registry = new ComponentRegistry([ButtonComponent::class]);

        self::assertTrue($registry->has('button'));
        self::assertSame(ButtonComponent::class, $registry->resolve('button'));
        self::assertSame(['button' => ButtonComponent::class], $registry->all());
    }

    public function testItExposesComponentMetadata(): void
    {
        $registry = new ComponentRegistry([ButtonComponent::class]);
        $metadata = $registry->metadata();

        self::assertSame('button', $metadata['button']['name']);
        self::assertSame('actions', $metadata['button']['category']);
        self::assertSame(ButtonComponent::schema(), $metadata['button']['schema']);
    }

    public function testItRejectsDuplicateNames(): void
    {
        $registry = new ComponentRegistry([ButtonComponent::class]);

        $this->expectException(DuplicateComponentException::class);
        $registry->register(ButtonComponent::class);
    }

    public function testItRejectsClassesThatAreNotComponents(): void
    {
        $registry = new ComponentRegistry();

        $this->expectException(InvalidComponentException::class);
        $registry->register(self::class);
    }

    public function testItFailsWhenComponentDoesNotExist(): void
    {
        $registry = new ComponentRegistry();

        $this->expectException(ComponentNotFoundException::class);
        $registry->resolve('missing');
    }
}