<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Token;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens, SoftDeletes, HasRoles;

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
        'deleted_at'
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
