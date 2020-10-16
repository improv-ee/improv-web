<?php

namespace Tests\Unit\Orm;

use App\Orm\Event;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use JoggApp\GoogleTranslate\GoogleTranslate;
use Mockery;
use Tests\TestCase;

class EventTest extends TestCase
{

    use DatabaseMigrations;


    public function testEventCreationInForeignLanguageSavesDefaultEnglishTranslation()
    {

        /** @var \Mockery\MockInterface $mockClient */
        $mockClient = $this->mock(GoogleTranslate::class);
        $mockClient->shouldReceive('justTranslate')->atLeast()->times(3)
            ->andReturnUsing(function ($inputText) {
                return 'translated-' . $inputText;
            });

        $event = Event::factory()->create();

        $defaultLocale = config('app.fallback_locale');

        $this->assertEquals('translated-'.$event->title,$event->translate($defaultLocale)->title);
        $this->assertEquals('translated-'.$event->description,$event->translate($defaultLocale)->description);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

}
