<?php

namespace App\Orm;

use Dimsav\Translatable\Translatable;
use Dirape\Token\DirapeToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableInterface;

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


    public function getRouteKeyName()
    {
        return 'uid';
    }
}
