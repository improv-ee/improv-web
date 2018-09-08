<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['title', 'slug'];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = trim($value);
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value);
    }

    public function organizations()
    {
        return $this->belongsToMany('App\Orm\Organization');
    }
}
