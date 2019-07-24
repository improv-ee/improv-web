<?php

namespace App\Orm;

use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Dirape\Token\DirapeToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableInterface;

/**
 * @property string $title
 * @property string $description
 * @property Carbon $start_time
 * @property Carbon $end_time
 * @property int $place_id
 */
class Event extends Model implements AuditableInterface
{
    use Translatable, DirapeToken, SoftDeletes, Auditable;

    protected $DT_Column = 'uid';
    protected $DT_settings = ['type' => DT_Unique, 'size' => 16, 'special_chr' => false];
    public $translatedAttributes = ['description', 'title'];
    protected $fillable = ['production_id', 'start_time', 'end_time'];
    protected $dates = [
        'created_at',
        'updated_at',
        'start_time',
        'end_time',
        'deleted_at'
    ];

    public function production()
    {
        return $this->belongsTo('App\Orm\Production');
    }

    public function place()
    {
        return $this->belongsTo('App\Orm\Place');
    }


    public function getRouteKeyName()
    {
        return 'uid';
    }
}
