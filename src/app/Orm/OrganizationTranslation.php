<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrganizationTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['name'];

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