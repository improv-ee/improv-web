<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * Class OrganizationTranslation
 * @package App\Orm
 * @property string name
 * @property string locale
 * @property string description
 * @property string slug
 * @property int organization_id
 */
class OrganizationTranslation extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, HasSlug;
    public $timestamps = false;
    protected $fillable = ['name', 'description'];


    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50);
    }
}