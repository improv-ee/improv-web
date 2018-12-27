<?php

namespace App\Orm;

use App\User;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use OwenIt\Auditing\Contracts\Auditable;

class Production extends Model implements Auditable
{
    use \Dimsav\Translatable\Translatable, SoftDeletes, SoftCascadeTrait, \OwenIt\Auditing\Auditable;

    public $translatedAttributes = ['title', 'slug', 'description', 'excerpt'];
    public $fillable = ['title', 'slug', 'description', 'excerpt'];

    protected $softCascade = ['events'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function organizations()
    {
        return $this->belongsToMany('App\Orm\Organization')->using('App\Orm\OrganizationProduction');
    }

    /**
     * @param Builder $query
     * @param User $user
     * @return Builder
     */
    public function scopeBelongingToUser(Builder $query, User $user) : Builder
    {

        // This is not the most performant or elegant way to implement it.
        // Leaving it in for the sake of working MVP, until performance becomes an issue
        // (future me: sorry!)
        $organizationIds = $user->organizations()->get()->pluck('id')->toArray();
        $productionIds = OrganizationProduction::whereIn('organization_id', $organizationIds)->get()->pluck('production_id')->toArray();

        return $query->whereIn('id', $productionIds);
    }

    public function header_img()
    {
        return $this->hasOne('App\Orm\Image', 'id', 'header_img_id');
    }

    public function events()
    {
        return $this->hasMany('App\Orm\Event');
    }
}
