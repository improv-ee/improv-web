<?php

namespace Tests\Feature\Api\Gigad;

use App\Orm\Event;
use App\Orm\Gigad;
use App\Orm\GigCategory;
use App\Orm\Organization;
use App\Orm\OrganizationProduction;
use App\Orm\Place;
use App\Orm\Production;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Tests\Feature\Api\ApiTestCase;
use Tests\Mocks\Vendor\Skagarwal\GooglePlacesApi\GooglePlaces;

/**
 * @package Tests\Feature\Api
 * @covers \App\Http\Controllers\Api\V1\GigCategoryController
 */
class CategoryTest extends ApiTestCase
{
    use DatabaseMigrations;

    /**
     * @var GigCategory
     */
    private GigCategory $gigCategory;

    protected function setUp(): void
    {
        parent::setUp();

        Organization::factory()->create();
        GigCategory::factory()->count(5)->create();
        $this->gigCategory = GigCategory::factory()->create();
    }

    public function testGigCategoryListCanBeFetched()
    {
        $response = $this->get($this->getApiUrl() . '/gigcategories');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $this->gigCategory->id,
                'description' => $this->gigCategory->description
            ])
            ->assertJsonCount(6, 'data');
    }

    public function testGigCategoryListCanBeFilteredByChildPublicStatus()
    {

        Gigad::factory()->count(3)->create(['is_public' => 0]);
        $gigad = Gigad::factory()->make();
        $gigad->is_public = 1;
        $gigad->gig_category_id = $this->gigCategory->id;
        $gigad->save();

        $response = $this->get($this->getApiUrl() . '/gigcategories?filter[gigads.is_public]=1');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $this->gigCategory->id
            ])
            ->assertJsonCount(1, 'data');
    }
}
