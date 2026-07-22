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

    /**
     * Feature flags available during the application foundation stage.
     * They can later be moved to persistence without changing consumers.
     *
     * @var array<string, bool>
     */
    public array $features = [
        'dashboard'     => true,
        'health_check'  => true,
        'crm'           => false,
        'workflow'      => false,
        'inventory'     => false,
        'operations'    => false,
        'reporting'     => false,
    ];

    /**
     * Initial module registry. PR-005 will replace this static registry with
     * module discovery and module-owned manifests.
     *
     * @var array<string, array<string, mixed>>
     */
    public array $modules = [
        'dashboard' => [
            'label'   => 'Dashboard',
            'route'   => '/',
            'icon'    => 'dashboard',
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
