<?php

namespace Tests\Unit\Orm\Filters;

use App\Orm\Filters\FilterTranslatedName;
use App\Orm\Organization;
use App\Orm\OrganizationTranslation;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Tests\TestCase;

class FilterTranslatedNameTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @covers \App\Orm\Filters\FilterTranslatedName
     */
    public function testFilterReturnsOnlyResultsOfCurrentLocale()
    {

        $organizations = Organization::factory()->count( 4)->create();

        $t1 = new OrganizationTranslation;
        $t1->organization_id = $organizations[0]->id;
        $t1->name = 'Box car 2';
        $t1->locale = 'ru';
        $t1->save();

        $t1 = new OrganizationTranslation;
        $t1->organization_id = $organizations[0]->id;
        $t1->name = 'Box car 2';
        $t1->locale = 'fr';
        $t1->save();

        $t1 = new OrganizationTranslation;
        $t1->organization_id = $organizations[2]->id;
        $t1->name = 'Box car 6';
        $t1->locale = 'fr';
        $t1->save();

        $t1 = new OrganizationTranslation;
        $t1->organization_id = $organizations[1]->id;
        $t1->name = 'Circle car 6';
        $t1->locale = 'fr';
        $t1->save();

        app()->setLocale('fr');

        $request = Request::create('/', 'GET', ['filter' => ['name' => 'Box']]);

        $fileredOrganizations = QueryBuilder::for(Organization::class, $request)
            ->allowedFilters(AllowedFilter::custom('name', new FilterTranslatedName))
            ->count();

        $this->assertEquals(2, $fileredOrganizations);
    }

}
