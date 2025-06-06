<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Log;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*public function canAccessPanel(Panel $panel): bool
    {
        \Log::info('canAccessPanel called for user ID: ' . $this->id);
        return $this->hasAnyRole(['admin', 'admin']);
    }*/


    public function canAccessPanel(Panel $panel): bool
    {

        //\Log::info('canAccessPanel called for user ID: ' . $panel->getId());
        if ($panel->getId() == 'super-admin') {
          //  \Log::info('canAccessPanel called for user ID super admin: ' . $this->id);
            return str_ends_with($this->email, '@proser.com.mx') && $this->hasVerifiedEmail();
        } elseif ($panel->getId() == 'usuario') {
            //\Log::info('canAccessPanel called for user ID usuario: ' . $this->id);
            return str_ends_with($this->email, '@proser.com.mx') && $this->hasVerifiedEmail();
        }   

        return true;
    }


}
