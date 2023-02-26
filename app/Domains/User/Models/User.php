<?php

namespace App\Domains\User\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ADMINISTRATOR = 1;
    const ADMIN = 2;
    const MEMBER = 3;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'name',
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

    /**
     * @return bool
     */
    public function isAdministrator(): bool
    {
        return $this->role_id == self::ADMINISTRATOR;
    }

    /**
     * @return bool
     */
    public function isAdmins(): bool
    {
        return $this->role_id == self::ADMIN;
    }

    /**
     * @return bool
     */
    public function isMember(): bool
    {
        return $this->role_id == self::MEMBER;
    }
}
