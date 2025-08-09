<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Helpers\UserHelper;

class GenerateCustomIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:generate-custom-ids {--force : Force regenerate all custom IDs}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate custom IDs for users that do not have them';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('ANCHOR: Starting custom ID generation...');

        $users = User::whereNull('custom_id')->orWhere('custom_id', '')->get();
        
        if ($users->isEmpty() && !$this->option('force')) {
            $this->info('All users already have custom IDs.');
            return;
        }

        if ($this->option('force')) {
            $users = User::all();
            $this->warn('Force mode: Regenerating all custom IDs...');
        }

        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        foreach ($users as $user) {
            $customId = UserHelper::generateCustomId($user->role_id);
            $user->update(['custom_id' => $customId]);
            
            $this->line("\nGenerated {$customId} for {$user->name} ({$user->email})");
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Custom ID generation completed successfully!');

        // Show summary
        $this->newLine();
        $this->info('Summary:');
        $this->table(
            ['Role', 'Prefix', 'Count'],
            $this->getRoleSummary()
        );
    }

    /**
     * ANCHOR: Get summary of users by role
     */
    private function getRoleSummary()
    {
        $summary = [];
        $roles = [
            1 => 'Kepala PPM',
            2 => 'Koordinator KKN', 
            3 => 'Admin',
            4 => 'Mahasiswa KKN',
            5 => 'Dosen Pembimbing Lapangan'
        ];

        foreach ($roles as $roleId => $roleName) {
            $count = User::where('role_id', $roleId)->count();
            $prefix = UserHelper::getRolePrefix($roleId);
            $summary[] = [$roleName, $prefix, $count];
        }

        return $summary;
    }
}
