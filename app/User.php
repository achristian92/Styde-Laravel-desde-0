<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function profile()
    {
        return $this->hasOne(UserProfile::class)->withDefault();
    }

    public static function findByEmail($email)
    {
        return static::where(compact('email'))->first();
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function profession() //columna profession_id si no le pasamos segundo parametros
    {
        return $this->belongsTo(Profession::class); //un usuario perteneze a una profession
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class,'user_skill');
    }


}
