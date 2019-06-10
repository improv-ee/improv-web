<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class EventTranslation extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'auto_translated' => 'boolean',
    ];

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = trim($value);
    }
}