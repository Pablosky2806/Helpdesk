<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CheckUserRoleCommand extends Command
{
    protected $signature = 'user:check-role {email}';
    protected $description = 'Check the role of a specific user';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found");
            return 1;
        }
        
        $this->info("User: {$user->name} ({$user->email})");
        $this->info("Role: {$user->role}");
        $this->info("Is Admin: " . ($user->isAdmin() ? 'Yes' : 'No'));
        $this->info("Is Tecnico: " . ($user->isTecnico() ? 'Yes' : 'No'));
        $this->info("Is User: " . ($user->isUser() ? 'Yes' : 'No'));
        
        return 0;
    }
}
