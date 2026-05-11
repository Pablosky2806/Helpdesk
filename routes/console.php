<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('user:check-role', function ($email) {
    $user = \App\Models\User::where('email', $email)->first();
    
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
})->purpose('Check the role of a specific user');
