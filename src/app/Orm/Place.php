<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @property int $id
 * @property string $uid
 */
class Place extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable, HasFactory;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = ['uid'];


    public function events()
    {
        return $this->hasMany('App\Orm\Event');
    }

}
