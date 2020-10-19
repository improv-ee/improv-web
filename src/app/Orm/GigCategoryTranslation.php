<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Model;

/**
 * @package App\Orm
 * @property string name
 * @property string locale
 * @property string description
 */
class GigCategoryTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'description'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'auto_translated' => 'boolean',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

}
