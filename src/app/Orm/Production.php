<?php

namespace App\Orm;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Production extends Model
{
    use \Dimsav\Translatable\Translatable, SoftDeletes, SoftCascadeTrait;

    public $translatedAttributes = ['title', 'slug', 'description', 'excerpt'];
    public $fillable = ['title', 'slug', 'description', 'excerpt'];

    protected $softCascade = ['events'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function organizations()
    {
        return $this->belongsToMany('App\Orm\Organization');
    }


    public function header_img()
    {
        return $this->hasOne('App\Orm\Image', 'id', 'header_img_id');
    }

    public function events()
    {
        return $this->hasMany('App\Orm\Event');
    }
}
