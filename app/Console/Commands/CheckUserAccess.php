<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CheckUserAccess extends Command
{
    protected $signature = 'check:user-access {user_id=1}';
    protected $description = 'Verifica roles, permisos y acceso a Filament para un usuario';

    public function handle()
    {
        $userId = $this->argument('user_id');

        $user = User::find($userId);

        if (! $user) {
            $this->error("Usuario con ID $userId no encontrado.");
            return 1;
        }

        $this->info("Usuario: {$user->name} (ID: {$user->id})");

        $roles = $user->getRoleNames();
        $this->info('Roles: ' . ($roles->isEmpty() ? 'Ninguno' : $roles->join(', ')));

        $permissions = $user->getAllPermissions()->pluck('name');
        $this->info('Permisos: ' . ($permissions->isEmpty() ? 'Ninguno' : $permissions->join(', ')));

        $canAccessFilament = $user->canAccessFilament() ? 'Sí' : 'No';
        $this->info("Puede acceder a Filament: $canAccessFilament");

        return 0;
    }
}
