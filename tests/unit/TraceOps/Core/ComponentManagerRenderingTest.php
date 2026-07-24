<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\Core;

use App\Libraries\TraceOps\Core\ComponentManager;
use App\Libraries\TraceOps\UI\BaseComponent;
use App\Libraries\TraceOps\UI\Components\ButtonComponent;
use App\Libraries\TraceOps\UI\Rendering\Contracts\RendererInterface;
use App\Libraries\TraceOps\UI\Rendering\RenderContext;
use PHPUnit\Framework\TestCase;

final class ComponentManagerRenderingTest extends TestCase
{
    public function testItCreatesAndRendersARegisteredComponent(): void
    {
        $renderer = new class implements RendererInterface {
            public function render(BaseComponent $component, ?RenderContext $context = null): string
            {
                return $component::name() . ':' . $component->props()['label'] . ':' . ($context?->theme() ?? 'default');
            }
        };

        $manager = new ComponentManager([ButtonComponent::class], renderer: $renderer);

        $output = $manager->renderComponent(
            'button',
            ['label' => 'Aprobar'],
            new RenderContext(theme: 'corporate')
        );

        self::assertSame('button:Aprobar:corporate', $output);
    }
}
