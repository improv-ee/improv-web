<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Relations\Pivot;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @property Production production
 * @property Organization organization
 */
class OrganizationProduction extends Pivot implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    const ROLE_ADMIN = 0;
    const ROLE_MEMBER = 1;

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $table = 'organization_production';

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function production()
    {
        return $this->belongsTo(Production::class);
    }
}
