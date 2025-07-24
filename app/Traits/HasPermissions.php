<?php

namespace App\Traits;

trait HasPermissions
{
    /**
     * Check if user has specific permission
     */
    public function hasPermission(string $permission): bool
    {
        if (!$this->role) {
            return false;
        }

        $permissions = explode('|', $this->role->access);
        return in_array($permission, $permissions);
    }

    /**
     * Check if user has any of the given permissions
     */
    public function hasAnyPermission(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if user has all of the given permissions
     */
    public function hasAllPermissions(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get all permissions for the user
     */
    public function getPermissions(): array
    {
        if (!$this->role) {
            return [];
        }

        $permissions = explode('|', $this->role->access);
        // Filter out empty strings
        return array_filter($permissions, function($permission) {
            return !empty(trim($permission));
        });
    }
} 