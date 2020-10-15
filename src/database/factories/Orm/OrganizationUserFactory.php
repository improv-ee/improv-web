<?php
namespace Database\Factories\Orm;

use App\Orm\OrganizationUser;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationUserFactory extends Factory {
    protected $model = OrganizationUser::class;

    public function definition()
    {
        $user = User::factory()->create();
        $organization = \App\Orm\Organization::factory()->create();

        return [
            'organization_id' => $organization->id,
            'creator_id' => $user->id,
            'user_id' => $user->id,
            'role' => \App\Orm\OrganizationUser::ROLE_MEMBER

        ];
    }
}

