<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'block',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


    public function hasRole(string $role): bool
    {
        $rolesCount = $this->roles
            ->where('name', '=', mb_strtolower($role) )
            ->count();
        return $rolesCount !== 0;
    }


    /**
     * @return bool
     * Description: для определения прав пользователя, отличается от hasRights
     */
    public static function hasRightsAdmin(): bool
    {
        return Auth::user() && Auth::user()->hasRole('admin' ); // Admin
    }


}
