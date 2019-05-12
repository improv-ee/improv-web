<?php

namespace Tests\Unit\Http\Requests\Production;

use App\Http\Requests\Production\UpdateProductionRequest;
use App\Orm\Organization;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

/**
 * @covers \App\Http\Requests\Production\UpdateProductionRequest
 */
class UpdateProductionRequestTest extends TestCase
{
    use DatabaseMigrations;

    protected $validInput = [
        'excerpt' => 'Harry was a wizard...',
        'title' => 'Harry Potter',
        'description' => 'It begin on a quiet night...',
        'organizations' => []
    ];

    /**
     * @var UpdateProductionRequest
     */
    protected $request;


    protected function setUp() : void
    {
        parent::setUp();
        $this->request = new UpdateProductionRequest;
        $organization = factory(Organization::class)->create();
        $this->validInput['organizations'] = [$organization->slug];
    }


    public function testValidOrganizationListIsAccepted()
    {
        $user = $this->actingAsOrganizationMember();

        $organizations = array_replace($this->validInput, ['organizations' => [$user->organizations()->first()->slug]]);
        $validator = Validator::make($organizations, $this->request->rules());
        $fails = $validator->fails();

        $this->assertFalse($fails);
    }

    public function testOrganizationsMustBeArray()
    {
        $input = $this->validInput;
        $input['organizations'] = 'slug';

        $validator = Validator::make($input, $this->request->rules());
        $fails = $validator->fails();

        $this->assertTrue($fails);
    }

    public function testNonExistingOrganizationIsNotAccepted()
    {
        $input = $this->validInput;
        $input['organizations'] = ['hogwarts'];

        $validator = Validator::make($input, $this->request->rules());
        $fails = $validator->fails();

        $this->assertTrue($fails);
    }

}