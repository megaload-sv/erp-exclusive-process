<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\Core\Capabilities;

use App\Libraries\TraceOps\Core\Capabilities\BehaviorResolver;
use App\Libraries\TraceOps\Core\Capabilities\CapabilityRegistry;
use App\Libraries\TraceOps\Core\Capabilities\ClickableCapability;
use App\Libraries\TraceOps\Core\Capabilities\RenderableCapability;
use App\Libraries\TraceOps\UI\Components\ButtonComponent;
use PHPUnit\Framework\TestCase;

final class CapabilityEngineTest extends TestCase
{
    public function testRegistryAndDescriptorResolveSemanticCapabilities(): void
    {
        $registry = new CapabilityRegistry([
            RenderableCapability::class,
            ClickableCapability::class,
        ]);

        $descriptor = ButtonComponent::describe();
        $resolver = new BehaviorResolver($registry);

        self::assertTrue($registry->has('renderable'));
        self::assertTrue($descriptor->supports(ClickableCapability::class));
        self::assertTrue($resolver->supports($descriptor, 'renderable'));
        self::assertSame([$descriptor], $resolver->componentsSupporting([$descriptor], ClickableCapability::class));
    }
}
