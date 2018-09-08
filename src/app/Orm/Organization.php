<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name','slug'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

    public function productions()
    {
        return $this->belongsToMany('App\Orm\Production');
    }
}
