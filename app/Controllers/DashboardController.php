<?php

namespace App\Controllers;

final class DashboardController extends BaseController
{
    public function index(): string
    {
        $dbStatus = 'Not configured';

        try {
            $database = db_connect();
            $database->initialize();
            $dbStatus = $database->connID ? 'Connected' : 'Unavailable';
        } catch (\Throwable) {
            $dbStatus = 'Unavailable';
        }

        $modules = array_map(
            static fn (array $module, string $key): array => [
                'key'     => $key,
                'label'   => $module['label'],
                'route'   => $module['route'],
                'icon'    => $module['icon'],
                'enabled' => $module['enabled'],
            ],
            $this->traceOps->modules,
            array_keys($this->traceOps->modules),
        );

        return view('dashboard/index', array_merge($this->viewData, [
            'title'       => 'Dashboard',
            'tagline'     => $this->traceOps->tagline,
            'company'     => $this->traceOps->company,
            'environment' => ENVIRONMENT,
            'phpVersion'  => PHP_VERSION,
            'ciVersion'   => \CodeIgniter\CodeIgniter::CI_VERSION,
            'dbStatus'    => $dbStatus,
            'modules'     => $modules,
        ]));
    }
}
