<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\UI\Rendering\Contracts;

use App\Libraries\TraceOps\UI\BaseComponent;
use App\Libraries\TraceOps\UI\Rendering\RenderContext;

interface RendererInterface
{
    public function render(BaseComponent $component, ?RenderContext $context = null): string;
}
