<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Image extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function productions()
    {
        return $this->belongsToMany('App\Orm\Production','productions','header_img_id');
    }
}
