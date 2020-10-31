<?php

namespace App\Orm;

use App\Orm\Traits\HasCoverImage;
use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Dirape\Token\DirapeToken;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableInterface;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

/**
 * @property int $id
 * @property string $uid
 * @property string $title
 * @property string $description
 * @property Carbon $start_time
 * @property Carbon $end_time
 * @property int $place_id
 * @property int $production_id
 * @property Place $place
 * @property Production $production
 */
class Event extends Model implements AuditableInterface, HasMedia
{
    use Translatable, DirapeToken, SoftDeletes, Auditable, InteractsWithMedia, HasFactory, HasCoverImage;

    protected $DT_Column = 'uid';
    protected $DT_settings = ['type' => DT_Unique, 'size' => 16, 'special_chr' => false];
    public $translatedAttributes = ['description', 'title'];
    protected $fillable = ['production_id', 'start_time', 'end_time'];
    protected $dates = [
        'created_at',
        'updated_at',
        'start_time',
        'end_time',
        'deleted_at'
    ];

    public function production()
    {
        return $this->belongsTo('App\Orm\Production');
    }

    public function place()
    {
        return $this->belongsTo('App\Orm\Place');
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

    /**
     * @return SpatieMedia|null
     */
    public function getHeaderImage(): ?SpatieMedia
    {
        if ($this->hasMedia('images')) {
            return $this->getFirstMedia('images');
        }
        return $this->production->getFirstMedia('images');
    }

    /**
     * Get event title, if it has one; otherwise default to parent Production title
     *
     * @return string|null
     */
    public function getTitleOrParent(): ?string
    {
        if ($this->title !== null) {
            return $this->title;
        }
        return $this->production->title;
    }
}
