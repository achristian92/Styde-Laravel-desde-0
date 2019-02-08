<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','profession_id'
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

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public static function findByEmail($email)
    {
        return static::where(compact($email))->first();
    }

    public function isAdmin()
    {
        return $this->isAdmin;
    }

    public function profession() //columna profession_id si no le pasamos segundo parametros
    {
        return $this->belongsTo(Profession::class); //un usuario perteneze a una profession
    }


}
