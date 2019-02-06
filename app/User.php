<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
      'is_admin' => 'boolean' //converit de entero a bolleano
    ];

    public function findByEmail($email)
    {
        return static::where(compact($email))->first();
    }

    public function isAdmin()
    {
        return $this->email === 'dulio@styde.net';
    }
}
