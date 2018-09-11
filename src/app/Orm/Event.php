<?php

namespace App\Orm;

use Dirape\Token\DirapeToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use \Dimsav\Translatable\Translatable, DirapeToken, SoftDeletes;

    protected $DT_Column='uid';
    protected $DT_settings=['type'=>DT_Unique,'size'=>10,'special_chr'=>false];
    public $translatedAttributes = ['description','title'];
protected $fillable = ['production_id','start_time','end_time'];
    protected $dates = [
        'created_at',
        'updated_at',
        'start_time',
        'end_time',
        'deleted_at'
    ];

    public function setProductionIdAttribute($value) {
        $this->attributes['production_id'] = $value;
        $this->setToken();
    }

    public function production()
    {
        return $this->belongsTo('App\Orm\Production');
    }
}
