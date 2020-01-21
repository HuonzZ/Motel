<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Categories extends Model
{

    protected $table ="categories";
    protected $fillable = [
        'id',
        'name',
        'slug',
    ];
    public $timestamps = false;

    public function motelroom(){
    	return $this->hasMany('App\Motelroom','category_id','id');
    }
}
