<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ANCHOR: Populate custom_id for existing users
        $users = User::all();
        
        foreach ($users as $user) {
            $customId = $this->generateCustomId($user->role_id, $user->id);
            $user->update(['custom_id' => $customId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->update(['custom_id' => null]);
    }

    /**
     * ANCHOR: Generate custom ID based on role and existing user count
     */
    private function generateCustomId($roleId, $userId)
    {
        $prefix = $this->getRolePrefix($roleId);
        
        // Count existing users with same role and lower ID
        $count = User::where('role_id', $roleId)
                    ->where('id', '<=', $userId)
                    ->count();
        
        return $prefix . str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    /**
     * ANCHOR: Get role prefix mapping
     */
    private function getRolePrefix($roleId)
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
};
