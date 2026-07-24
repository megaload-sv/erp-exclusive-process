<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class TraceOps extends BaseConfig
{
    public string $name = 'TraceOps ERP';
    public string $version = '0.1.0-alpha';
    public string $tagline = 'Engineering Beyond Code';
    public string $company = 'Grupo Megaload';
    public string $timezone = 'America/El_Salvador';

    /** @var array<string, bool> */
    public array $features = [
        'dashboard'     => true,
        'health_check'  => true,
        'developer'     => true,
        'crm'           => false,
        'workflow'      => false,
        'inventory'     => false,
        'operations'    => false,
        'reporting'     => false,
    ];

    /** @var array<string, array<string, mixed>> */
    public array $modules = [
        'dashboard' => [
            'label'   => 'Dashboard',
            'route'   => '/',
            'icon'    => 'dashboard',
            'enabled' => true,
        ],
        'developer' => [
            'label'   => 'Developer',
            'route'   => '/developer',
            'icon'    => 'code',
            'enabled' => true,
        ],
        'crm' => [
            'label'   => 'CRM',
            'route'   => '/crm',
            'icon'    => 'users',
            'enabled' => false,
        ],
        'workflow' => [
            'label'   => 'Workflow',
            'route'   => '/workflow',
            'icon'    => 'workflow',
            'enabled' => false,
        ],
        'inventory' => [
            'label'   => 'Inventario',
            'route'   => '/inventory',
            'icon'    => 'boxes',
            'enabled' => false,
        ],
    ];
}
