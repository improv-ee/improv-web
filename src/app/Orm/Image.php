<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Image
 * @package App\Orm
 * @property string $uid
 * @property string $filename
 */
class Image extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function productions()
    {
        return $this->hasMany('App\Orm\Production','header_img_id');
    }


    public function getRouteKeyName():string
    {
        return 'uid';
    }
}
