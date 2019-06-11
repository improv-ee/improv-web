<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class OrganizationTranslation
 * @package App\Orm
 * @property string name
 * @property string locale
 * @property string description
 * @property int organization_id
 */
class OrganizationTranslation extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
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