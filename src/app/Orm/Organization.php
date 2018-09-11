<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use \Dimsav\Translatable\Translatable,SoftDeletes;

    public $translatedAttributes = ['name','slug'];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

    public function productions()
    {
        return $this->belongsToMany('App\Orm\Production');
    }
}
