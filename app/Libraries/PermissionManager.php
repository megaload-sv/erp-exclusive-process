<?php

declare(strict_types=1);

namespace App\Libraries;

final class PermissionManager
{
    /**
     * Temporary foundation contract. The authorization implementation will be
     * completed in PR-004 when users, roles and permissions are introduced.
     */
    public function allows(?int $userId, string $permission): bool
    {
        return false;
    }
}
