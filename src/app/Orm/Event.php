<?php

namespace App\Orm;

use Dirape\Token\DirapeToken;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use \Dimsav\Translatable\Translatable, DirapeToken;

    protected $DT_Column='uid';
    protected $DT_settings=['type'=>DT_Unique,'size'=>10,'special_chr'=>false];
    public $translatedAttributes = ['description','title'];

    protected $dates = [
        'created_at',
        'updated_at',
        'start_time',
        'end_time'
    ];

    public function production()
    {
        return $this->belongsTo('App\Orm\Production');
    }
}
