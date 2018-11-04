<?php

namespace App\Orm;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Organization extends Model
{
    use \Dimsav\Translatable\Translatable, SoftDeletes;

    public $translatedAttributes = ['name', 'slug'];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = ['name'];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

    public function productions()
    {
        return $this->belongsToMany('App\Orm\Production');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function isMember(User $targetUser = null): bool {
        if ($targetUser === null) {
            return false;
        }
        return $this->users->contains($targetUser->id);
    }

    /**
     * @param Builder $query
     * @param bool $enabled
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyMine(Builder $query, bool $enabled)
    {
        if (!$enabled) {
            return $query;
        }
        return $query->whereHas('users', function ($query) {
            $query->where('id', Auth::user()->id ?? null);
        });
    }
}
