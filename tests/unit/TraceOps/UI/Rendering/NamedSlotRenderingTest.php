<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\UI\Rendering;

use App\Libraries\TraceOps\UI\Components\ButtonComponent;
use App\Libraries\TraceOps\UI\Rendering\HtmlViewRenderer;
use PHPUnit\Framework\TestCase;

final class NamedSlotRenderingTest extends TestCase
{
    public function testItRendersNamedSlotsAndInjectsThemIntoTheParentView(): void
    {
        $page = new ButtonComponent(['label' => 'Page']);
        $header = new ButtonComponent(['label' => 'Header']);
        $save = new ButtonComponent(['label' => 'Save']);
        $cancel = new ButtonComponent(['label' => 'Cancel']);

        $page->setSlot('header', $header)
            ->setSlot('actions', $save, $cancel);

        $renderer = new HtmlViewRenderer(
            static function (string $view, array $data): string {
                if ($data['label'] !== 'Page') {
                    return sprintf('<span>%s</span>', $data['label']);
                }

                return sprintf(
                    '<header>%s</header><main>%s</main>',
                    $data['_traceOpsSlotsHtml']['header'],
                    $data['_traceOpsSlotsHtml']['actions']
                );
            }
        );

        self::assertSame(
            '<header><span>Header</span></header><main><span>Save</span><span>Cancel</span></main>',
            $renderer->render($page)
        );
    }
}
