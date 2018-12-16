<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

class OrganizationTranslation extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    public $timestamps = false;
    protected $fillable = ['name', 'description'];

    public function setSlugAttribute($value)
    {
        $slug = trim(Str::limit(str_slug($value), 50, ''));
        $this->attributes['slug'] = $slug ?: null;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
        $this->slug = $value;
    }
}