<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['title', 'slug', 'description', 'excerpt'];


    public function organizations()
    {
        return $this->belongsToMany('App\Orm\Organization');
    }

    public function getHeaderImgAttribute(){
        return $this->attributes['header_img'] ?? asset('img/production/default-header.jpg');
    }

    public function events(){
        return $this->hasMany('App\Orm\Event');
    }
}
