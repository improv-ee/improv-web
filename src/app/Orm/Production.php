<?php

namespace App\Orm;

use App\Orm\Traits\HasCoverImage;
use App\User;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Dirape\Token\DirapeToken;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;
use Spatie\MediaLibrary\HasMedia;
use \Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

/**
 * @package App\Orm
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $excerpt
 * @property bool $hasUpcomingEvents
 * @property string $uid
 * @property int $creator_id
 */
class Production extends Model implements Auditable, HasMedia
{
    use Translatable,SoftDeletes, SoftCascadeTrait, DirapeToken, \OwenIt\Auditing\Auditable,
        InteractsWithMedia, HasTags, HasFactory, HasCoverImage;

    public $translatedAttributes = ['title', 'description', 'excerpt'];
    public $fillable = ['title', 'description', 'excerpt'];
    protected $DT_Column = 'uid';
    protected $DT_settings = ['type' => DT_Unique, 'size' => 16, 'special_chr' => false];


    protected $softCascade = ['events'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function organizations()
    {
        return $this->belongsToMany('App\Orm\Organization')->using('App\Orm\OrganizationProduction');
    }

    /**
     * @param Builder $query
     * @param User $user
     * @return Builder
     */
    public function scopeBelongingToUser(Builder $query, User $user): Builder
    {

        // This is not the most performant or elegant way to implement it.
        // Leaving it in for the sake of working MVP, until performance becomes an issue
        // (future me: sorry!)
        $organizationIds = $user->organizations()->get()->pluck('id')->toArray();
        $productionIds = OrganizationProduction::whereIn('organization_id', $organizationIds)->get()->pluck('production_id')->toArray();

        return $query->whereIn('id', $productionIds);
    }

    public function isMine(User $user = null): bool
    {
        if ($user === null) {
            $user = Auth::user();
        }

        if ($user === null) {
            return false;
        }

        $organizationIds = $user->organizations()->get()->pluck('id')->toArray();

        return (bool)OrganizationProduction::where('production_id', $this->id)
            ->whereIn('organization_id', $organizationIds)
            ->count();
    }

    /**
     * @return bool
     */
    public function getHasUpcomingEventsAttribute(): bool
    {
        return (bool)$this->events()->whereDate('end_time', '>=', Carbon::now(config('app.timezone')))->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany('App\Orm\Event');
    }

    /**
     * Overwrite spatie-tags package's default Tag model
     *
     * @return string
     */
    public static function getTagClassName(): string
    {
        return Tag::class;
    }

    /**
     * Overwrite spatie-tags package's default Tag model
     * @return MorphToMany
     */
    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), 'taggable', 'taggables', null, 'tag_id')
            ->orderBy('order_column');
    }


    public function getRouteKeyName()
    {
        return 'uid';
    }

    /**
     * @param SpatieMedia|null $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(SpatieMedia $media = null): void
    {
       $this->registerCoverImageConversion();
    }
}
