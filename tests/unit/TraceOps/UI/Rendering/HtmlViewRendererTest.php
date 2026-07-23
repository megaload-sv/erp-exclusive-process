<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\UI\Rendering;

use App\Libraries\TraceOps\UI\Components\ButtonComponent;
use App\Libraries\TraceOps\UI\Rendering\HtmlViewRenderer;
use App\Libraries\TraceOps\UI\Rendering\RenderContext;
use PHPUnit\Framework\TestCase;

final class HtmlViewRendererTest extends TestCase
{
    public function testItRendersTheComponentViewWithNormalizedDataAndContext(): void
    {
        $renderer = new HtmlViewRenderer(
            static function (string $view, array $data): string {
                return json_encode([
                    'view' => $view,
                    'data' => $data,
                ], JSON_THROW_ON_ERROR);
            }
        );

        $output = $renderer->render(
            new ButtonComponent(['label' => 'Guardar']),
            new RenderContext('corporate', 'es-SV', 'megaload')
        );

        $payload = json_decode($output, true, 512, JSON_THROW_ON_ERROR);

        self::assertSame('components/ui/button', $payload['view']);
        self::assertSame('Guardar', $payload['data']['label']);
        self::assertSame('primary', $payload['data']['variant']);
        self::assertSame('corporate', $payload['data']['_traceOps']['theme']);
        self::assertSame('es-SV', $payload['data']['_traceOps']['locale']);
        self::assertSame('megaload', $payload['data']['_traceOps']['tenant']);
    }
}
