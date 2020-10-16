<?php

namespace Tests\Unit\Orm;

use App\Orm\Production;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use JoggApp\GoogleTranslate\GoogleTranslate;
use Mockery;
use Tests\TestCase;

class ProductionTest extends TestCase
{

    use DatabaseMigrations;


    public function testProductionCreationInForeignLanguageSavesDefaultEnglishTranslation()
    {

        /** @var \Mockery\MockInterface $mockClient */
        $mockClient = $this->mock(GoogleTranslate::class);
        $mockClient->shouldReceive('justTranslate')->atLeast()->times(3)
            ->andReturnUsing(function ($inputText) {
                return 'translated-' . $inputText;
            });

        $production = Production::factory()->create();

        $defaultLocale = config('app.fallback_locale');

        $this->assertEquals('translated-'.$production->title,$production->translate($defaultLocale)->title);
        $this->assertEquals('translated-'.$production->description,$production->translate($defaultLocale)->description);
        $this->assertEquals('translated-'.$production->excerpt,$production->translate($defaultLocale)->excerpt);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

}
