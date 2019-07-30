<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Token;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @package App
 * @property string $username
 * @property string $name
 * @property string $email
 * @property string $password
 */
class User extends Authenticatable implements Auditable
{
    use Notifiable, HasApiTokens, SoftDeletes, HasRoles,\OwenIt\Auditing\Auditable;

    const OAUTH_WEB_TOKEN_NAME = 'web-token';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'email_verified_at'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function organizations()
    {
        return $this->belongsToMany('App\Orm\Organization')->using('App\Orm\OrganizationUser');
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
     * @param string $username
     * @return User
     */
    public function findForPassport(string $username): User
    {
        return $this->where('username', $username)->first();
    }

    /**
     * @return string
     */
    public function createWebToken(): string
    {
        $token = $this->createToken(User::OAUTH_WEB_TOKEN_NAME);
        return $token->accessToken;
    }

    /**
     *
     */
    public function revokeWebTokens()
    {
        $this->tokens->each(function (Token $token, $key) {
            if ($token->name === self::OAUTH_WEB_TOKEN_NAME) {
                $token->revoke();
            }
        });
    }
}
