<?php

namespace App\Orm;

use App\User;
use Illuminate\Database\Eloquent\Relations\Pivot;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @property User user
 * @property Organization organization
 */
class OrganizationUser extends Pivot implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    const ROLE_ADMIN = 0;
    const ROLE_MEMBER = 1;

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $table = 'organization_user';

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param int $userId
     * @param int $organizationId
     * @return OrganizationUser
     */
    public static function getMembership(int $userId, int $organizationId) : ?OrganizationUser
    {
        return OrganizationUser::where('user_id', $userId)
            ->where('organization_id', $organizationId)
            ->first();
    }
}
