<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\UI\Rendering;

use App\Libraries\TraceOps\Core\Tree\Contracts\NodeInterface;
use App\Libraries\TraceOps\UI\BaseComponent;
use App\Libraries\TraceOps\UI\Rendering\Contracts\RendererInterface;
use Closure;
use LogicException;

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
        return $this->renderComponent($component, $context ?? new RenderContext());
    }

    private function renderComponent(BaseComponent $component, RenderContext $context): string
    {
        $renderedChildren = [];

        foreach ($component->children() as $child) {
            $renderedChildren[] = $this->renderChild($child, $context);
        }

        $data = array_merge($component->toViewData(), [
            '_traceOps' => $context->toArray(),
            '_traceOpsChildren' => $renderedChildren,
            '_traceOpsChildrenHtml' => implode('', $renderedChildren),
        ]);

        if ($this->viewRenderer !== null) {
            return ($this->viewRenderer)($component::view(), $data);
        }

        return view($component::view(), $data);
    }

    private function renderChild(NodeInterface $child, RenderContext $context): string
    {
        if (! $child instanceof BaseComponent) {
            throw new LogicException(sprintf(
                'Node [%s] cannot be rendered by %s because it is not a UI component.',
                $child::class,
                self::class
            ));
        }

        return $this->renderComponent($child, $context);
    }
}
