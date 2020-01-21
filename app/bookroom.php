<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bookroom extends Model
{
    protected $table ="bookrooms";
    protected $fillable = [
        'id',
        'id_user',
        'id_motelroom',
        'startday',
        'endday',
        'number',
        'check',
    ];
    //thêm phương thức
    public function nguoithue(){
        return $this->belongsTo('App\User','id_user','id');
    }
    public function phongtro(){
        return $this->belongsTo('App\Motelroom','id_motelroom','id');
    }

    public $timestamps = false;
}
