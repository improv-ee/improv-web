<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Model;

/**
 * @package App\Orm
 * @property string link
 * @property string description
 */
class GigadTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['link', 'description'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'auto_translated' => 'boolean',
    ];

}
