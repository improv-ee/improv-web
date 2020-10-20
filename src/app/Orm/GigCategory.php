<?php

namespace App\Orm;

use App\Orm\Traits\HasCoverImage;
use Dirape\Token\DirapeToken;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property string $name
 * @property int $id
 * @property string $description
 * @property int $order
 * @package App\Orm
 */
class GigCategory extends Model
{
    use HasFactory;

    use \Astrotomic\Translatable\Translatable, SoftDeletes, HasFactory;

    public $translatedAttributes = ['name', 'description'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = ['description', 'name','order'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gigads()
    {
        return $this->hasMany('App\Orm\Gigad', 'gig_category_id');
    }
}
