<?php

namespace App\Orm;

use App\Orm\Traits\HasCoverImage;
use Dirape\Token\DirapeToken;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property string $link
 * @property int $id
 * @property int $is_public
 * @property int $organization_id
 * @property string $description
 * @property string $uid
 * @property string $gig_category_id
 * @property GigCategory $category
 * @property Organization $organization
 * @package App\Orm
 */
class Gigad extends Model implements Auditable, HasMedia
{
    use HasFactory;

    use \Astrotomic\Translatable\Translatable, SoftDeletes, \OwenIt\Auditing\Auditable, InteractsWithMedia,
        DirapeToken, HasFactory, HasCoverImage;

    protected $DT_Column = 'uid';
    protected $DT_settings = ['type' => DT_Unique, 'size' => 16, 'special_chr' => false];

    public $translatedAttributes = ['link', 'description'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = ['description', 'link', 'is_public'];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uid';
    }

    public function organization()
    {
        return $this->belongsTo('App\Orm\Organization');
    }

    public function category()
    {
        return $this->belongsTo(GigCategory::class, 'gig_category_id');
    }

    /**
     * @param Builder $query
     * @param bool $enabled
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyPublic(Builder $query, bool $enabled)
    {
        if (!$enabled) {
            return $query;
        }
        return $query->where('is_public', 1);
    }

    /**
     * @param Builder $query
     * @param bool $enabled
     * @return Builder
     */
    public function scopeOnlyMine(Builder $query, bool $enabled = false): Builder
    {

        if (!$enabled || !Auth::user()) {
            return $query;
        }

        // This is not the most performant or elegant way to implement it.
        // Leaving it in for the sake of working MVP, until performance becomes an issue
        // (future me: sorry!)
        $organizationIds = Auth::user()->organizations()->get()->pluck('id')->toArray();

        return $query->whereIn('organization_id', $organizationIds);
    }
}
