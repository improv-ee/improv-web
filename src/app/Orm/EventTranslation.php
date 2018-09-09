<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Model;

class EventTranslation extends Model {

public $timestamps = false;
public function setDescriptionAttribute($value) {
    $this->attributes['description'] = trim($value);
}
}