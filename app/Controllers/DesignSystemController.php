<?php

namespace App\Controllers;

final class DesignSystemController extends BaseController
{
    public function index(): string
    {
        return view('design-system/index', array_merge($this->viewData, [
            'title'   => 'Design System',
            'tagline' => $this->traceOps->tagline,
            'company' => $this->traceOps->company,
        ]));
    }
}
