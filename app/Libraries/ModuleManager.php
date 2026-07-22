<?php

declare(strict_types=1);

namespace App\Libraries;

final class ModuleManager
{
    /**
     * @return array<string, array{label:string, enabled:bool}>
     */
    public function all(): array
    {
        return [
            'dashboard' => ['label' => 'Dashboard', 'enabled' => true],
            'crm' => ['label' => 'CRM', 'enabled' => false],
            'customers' => ['label' => 'Customers', 'enabled' => false],
            'operations' => ['label' => 'Operations', 'enabled' => false],
            'workflow' => ['label' => 'Workflow', 'enabled' => false],
            'inventory' => ['label' => 'Inventory', 'enabled' => false],
            'accounting' => ['label' => 'Accounting', 'enabled' => false],
            'administration' => ['label' => 'Administration', 'enabled' => false],
        ];
    }

    public function isEnabled(string $module): bool
    {
        return $this->all()[$module]['enabled'] ?? false;
    }
}
