<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{


    public function productions()
    {
        return $this->belongsToMany('App\Orm\Production','productions','header_img_id');
    }
}
