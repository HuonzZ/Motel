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
    protected $table = "users";
    protected $fillable = [
        'id',
        'name',
        'username',
        'avatar',
        'dateofbrith',
        'gender',
        'address',
        'phone',
        'email',
        'password',
        'tinhtrang',
        'right',
    ];

    public function motelroom(){
        return $this->hasMany('App\Motelroom','user_id','id');
    }

//    public function chuphong(){
//        return $this->hasMany('App\Motelroom','id','user_id');
//    }
//    public function nguoithue(){
//        return $this->hasMany('App\Motelroom','id','user1_id');
//    }
    public function chuphong(){
        return $this->hasMany('App\Motelroom','id','user_id');
    }
    public function nguoithue(){
        return $this->hasMany('App\Motelroom','id','user1_id');
    }


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
