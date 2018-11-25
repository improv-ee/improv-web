<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class EventTranslation extends Model implements Auditable {
use \OwenIt\Auditing\Auditable;
public $timestamps = false;
public function setDescriptionAttribute($value) {
    $this->attributes['description'] = trim($value);
}
}