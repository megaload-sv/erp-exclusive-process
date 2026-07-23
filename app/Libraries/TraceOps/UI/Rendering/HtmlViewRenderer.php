<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\UI\Rendering;

use App\Libraries\TraceOps\UI\BaseComponent;
use App\Libraries\TraceOps\UI\Rendering\Contracts\RendererInterface;
use Closure;

final class HtmlViewRenderer implements RendererInterface
{
    /**
     * @param Closure(string, array<string, mixed>): string|null $viewRenderer
     */
    public function __construct(private readonly ?Closure $viewRenderer = null)
    {
    }

    public function render(BaseComponent $component, ?RenderContext $context = null): string
    {
        $context ??= new RenderContext();
        $data = array_merge($component->toViewData(), [
            '_traceOps' => $context->toArray(),
        ]);

        if ($this->viewRenderer !== null) {
            return ($this->viewRenderer)($component::view(), $data);
        }

        return view($component::view(), $data);
    }
}
