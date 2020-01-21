<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
class Motelroom extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;
    protected $table = "motelrooms";
    protected $fillable = [
        'id',
        'title',
        'description',
        'address',
        'area',
        'utilities',
        'price',
        'latlng',
        'images',
        'user_id',
        'user1_id',
        'category_id',
        'district_id',
        'phone',
        'count_view',
        'roomstatus',
        'approve',
        'startday',
        'endday',
        'number',
        'check',
        'slug',
    ];
//    public function chuphong(){
//        return $this->belongsTo('App\User','user_id','id');
//    }
//    public function nguoithue(){
//        return $this->belongsTo('App\User','user1_id','id');
//    }
    public function chuphong(){
        return $this->belongsTo('App\User','user_id','id');
    }
    public function nguoithue(){
        return $this->belongsTo('App\User','user1_id','id');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
    public function category(){
    	return $this->belongsTo('App\Categories','category_id','id');
    }
    public function district(){
    	return $this->belongsTo('App\District','district_id','id');
    }
    public function reports(){
        return $this->hasMany('App\Reports','id_motelroom','id');
    }

    // thêm phuopwng thức
    public function phongtro(){
        return $this->belongsTo('App\bookroom','id','id_motelroom');
    }
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
