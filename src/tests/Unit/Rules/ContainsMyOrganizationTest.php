<?php

namespace Tests\Unit\Rules;

use App\Orm\Organization;
use App\Rules\ContainsMyOrganization;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

/**
 * @package Tests\Unit\Rules
 * @covers \App\Rules\ContainsMyOrganization
 */
class ContainsMyOrganizationTest extends TestCase
{


    use DatabaseMigrations;

    /**
     * @var ContainsMyOrganization
     */
    protected $validator;

    protected function setUp() : void
    {
        parent::setUp();
        $this->validator = new ContainsMyOrganization;
    }

    public function testEmptyListFails()
    {
        $this->assertFalse($this->validator->passes('organizations', []));
    }

    public function testOnlyMyOrganizationPasses()
    {
        $user = $this->actingAsOrganizationMember();

        $this->assertTrue($this->validator->passes('organizations', [
            $user->organizations()->first()->slug
        ]));
    }

    public function testMyOrganizationInLargerListPasses()
    {
        $user = $this->actingAsOrganizationMember();
        $org1 = factory(Organization::class)->create();
        $org2 = factory(Organization::class)->create();

        $this->assertTrue($this->validator->passes('organizations', [
            $org1->slug,
            $user->organizations()->first()->slug,
            $org2->slug
        ]));
    }

    public function testMyOrganizationNotInListFails()
    {
        $this->actingAsOrganizationMember();
        $org1 = factory(Organization::class)->create();
        $org2 = factory(Organization::class)->create();

        $this->assertFalse($this->validator->passes('organizations', [
            $org1->slug,
            $org2->slug
        ]));
    }

    public function testReturnsFalseOnStringInput()
    {
        $this->assertFalse($this->validator->passes('organizations', 'Kaladin'));
    }
}
