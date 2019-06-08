<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class ProductionTranslation
 * @property int $production_id
 * @property string $description
 * @property string $title
 * @property string $locale
 * @property string $excerpt
 * @property boolean $auto_translated
 */
class ProductionTranslation extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public $timestamps = false;
    protected $fillable = ['title', 'description', 'excerpt'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'auto_translated' => 'boolean',
    ];

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = trim($value) ?: null;
    }

    public function setExcerptAttribute($value)
    {
        $this->attributes['excerpt'] = Str::limit(trim($value), 200) ?: null;
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = trim($value);
    }

}