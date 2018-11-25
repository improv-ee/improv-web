<?php

namespace App\Events\Organization;

use App\Orm\OrganizationUser;
use Illuminate\Queue\SerializesModels;

class UserJoined
{
    use SerializesModels;


    /**
     * @var OrganizationUser
     */
    public $organizationUser;

    public function __construct(OrganizationUser $organizationUser)
    {

        $this->organizationUser = $organizationUser;
    }
}