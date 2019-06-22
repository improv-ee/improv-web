<?php

namespace App\Orm;

use App\User;
use Dirape\Token\DirapeToken;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @property \Illuminate\Database\Eloquent\Collection $admins
 * @property string $email
 * @property string $uid
 * @property string $facebook_url
 * @property string $homepage_url
 * @property int $is_public
 */
class Organization extends Model implements Auditable, HasMedia
{
    use \Astrotomic\Translatable\Translatable, SoftDeletes, \OwenIt\Auditing\Auditable, HasMediaTrait, DirapeToken;

    protected $DT_Column = 'uid';
    protected $DT_settings = ['type' => DT_Unique, 'size' => 16, 'special_chr' => false];

    public $translatedAttributes = ['name', 'description'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = ['name', 'description', 'is_public', 'homepage_url', 'facebook_url', 'email'];

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
        return $this->belongsToMany('App\User')->withPivot(['role']);
    }

    public function admins()
    {
        return $this->users()
            ->wherePivot('role', OrganizationUser::ROLE_ADMIN);
    }

    public function isAdmin(User $targetUser = null): bool
    {
        if ($targetUser === null) {
            return false;
        }

        return (bool)$this->users()
            ->wherePivot('role', OrganizationUser::ROLE_ADMIN)
            ->wherePivot('user_id', $targetUser->id)
            ->count();
    }

    public function isMember(User $targetUser = null): bool
    {
        if ($targetUser === null) {
            return false;
        }
        return $this->users->contains($targetUser->id);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uid';
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
            $query->where('users.id', Auth::user()->id ?? null);
        });
    }
}
