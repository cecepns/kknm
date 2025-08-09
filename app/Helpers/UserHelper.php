<?php

namespace App\Helpers;

use App\Models\User;

class UserHelper
{
    /**
     * ANCHOR: Get role prefix mapping
     */
    public static function getRolePrefix($roleId)
    {
        $prefixes = [
            1 => 'Kep', // Kepala PPM
            2 => 'Kor', // Koordinator KKN
            3 => 'Adm', // Admin
            4 => 'Mah', // Mahasiswa KKN
            5 => 'Dos', // Dosen Pembimbing Lapangan
        ];
        
        return $prefixes[$roleId] ?? 'Usr';
    }

    /**
     * ANCHOR: Get role name from custom_id prefix
     */
    public static function getRoleNameFromPrefix($prefix)
    {
        $roleNames = [
            'Kep' => 'Kepala PPM',
            'Kor' => 'Koordinator KKN',
            'Adm' => 'Admin',
            'Mah' => 'Mahasiswa KKN',
            'Dos' => 'Dosen Pembimbing Lapangan',
        ];
        
        return $roleNames[$prefix] ?? 'Unknown';
    }

    /**
     * ANCHOR: Generate custom ID for new user
     */
    public static function generateCustomId($roleId)
    {
        $prefix = self::getRolePrefix($roleId);
        
        // Get the last user with the same role
        $lastUser = User::where('role_id', $roleId)
                       ->whereNotNull('custom_id')
                       ->orderBy('custom_id', 'desc')
                       ->first();
        
        if ($lastUser) {
            // Extract number from last custom_id and increment
            $lastNumber = (int) substr($lastUser->custom_id, 3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * ANCHOR: Format custom ID for display
     */
    public static function formatCustomId($customId)
    {
        if (!$customId) {
            return 'N/A';
        }
        
        return '<span class="badge badge-primary">' . $customId . '</span>';
    }

    /**
     * ANCHOR: Get user display name with custom ID
     */
    public static function getUserDisplayName($user)
    {
        $customId = $user->custom_id ?? 'N/A';
        return "{$customId} - {$user->name}";
    }

    /**
     * ANCHOR: Validate custom ID format
     */
    public static function validateCustomIdFormat($customId)
    {
        if (!$customId) {
            return false;
        }
        
        // Check if format matches: 3 letters + 3 digits
        return preg_match('/^[A-Za-z]{3}\d{3}$/', $customId);
    }
}
