<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';
    protected $fillable = [
        'id',
        'name',
        'slug',
    ];
    public $timestamps = false;
    public function motelroom(){
    	return $this->hasMany('App\Motelroom','district_id','id');
    }
}
