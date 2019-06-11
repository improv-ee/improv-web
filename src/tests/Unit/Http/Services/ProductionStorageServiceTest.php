<?php

namespace Tests\Unit\Http\Services;

use App\Http\Services\ProductionStorageService;
use App\Orm\Organization;
use App\Orm\Production;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Tests\TestCase;

/**
 * Class ProductionStorageServiceTest
 * @package Tests\Unit\Http\Services
 * @covers \App\Http\Services\ProductionStorageService
 */
class ProductionStorageServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var ProductionStorageService
     */
    protected $productionStorageService;


    /**
     * ProductionStorageServiceTest constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->productionStorageService = new ProductionStorageService;
    }

    public function testSaveProductionRemovesOldProductions()
    {
        /** @var Production $production */
        $production = factory(Production::class)->create();
        $organizations = factory(Organization::class, 3)->create();

        $production->organizations()->attach($organizations[0]);
        $production->organizations()->attach($organizations[1]);

        $request = Request::create('/', 'POST', ['organizations' => [$organizations[0]->uid, $organizations[1]->uid]]);
        $this->productionStorageService->save($production, $request);

        $this->assertEquals(2, $production->organizations()->count());
        $this->assertDatabaseHas('organization_production', ['production_id' => $production->id, 'organization_id' => $organizations[0]->id]);
        $this->assertDatabaseHas('organization_production', ['production_id' => $production->id, 'organization_id' => $organizations[1]->id]);
    }
}