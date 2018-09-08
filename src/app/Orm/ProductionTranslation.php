<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Model;

class ProductionTranslation extends Model {

public $timestamps = false;
protected $fillable = ['title'];

}