<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\Studio\ExplorerService;

final class StudioController extends BaseController
{
    public function index(): string
    {
        $explorer = (new ExplorerService())->build();

        return view('studio/index', array_merge($this->viewData, $explorer, [
            'title' => 'TraceOps Studio',
            'studioSection' => 'explorer',
            'runtimeVersion' => $this->traceOps->version,
        ]));
    }
}
