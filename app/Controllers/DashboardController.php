<?php

namespace App\Controllers;

use CodeIgniter\Controller;

final class DashboardController extends Controller
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

        return view('dashboard/index', [
            'title'       => 'Dashboard',
            'appName'     => env('app.name', 'TraceOps ERP'),
            'appVersion'  => env('app.version', '0.1.0-alpha'),
            'environment' => ENVIRONMENT,
            'phpVersion'  => PHP_VERSION,
            'ciVersion'   => \CodeIgniter\CodeIgniter::CI_VERSION,
            'dbStatus'    => $dbStatus,
            'modules'     => [
                'CRM',
                'Customers',
                'Operations',
                'Workflow',
                'Inventory',
                'Accounting',
                'Administration',
            ],
        ]);
    }
}
