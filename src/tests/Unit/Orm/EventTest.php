<?php

namespace Tests\Unit\Orm;

use App\Orm\Event;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use JoggApp\GoogleTranslate\GoogleTranslate;
use Mockery;
use Tests\TestCase;

class EventTest extends TestCase
{
    /**
     * @var Event
     */
    private Event $event;

    protected function setUp(): void
    {
        parent::setUp();
        $this->event = Event::factory()->create();
    }

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

        $this->assertEquals('translated-' . $event->title, $event->translate($defaultLocale)->title);
        $this->assertEquals('translated-' . $event->description, $event->translate($defaultLocale)->description);
    }

    public function testGetTitleOrParentReturnsEventTitleIfEventHasOne()
    {
        $this->assertEquals($this->event->title, $this->event->getTitleOrParent());
    }

    public function testGetTitleOrParentReturnsProductionTitleIfEventTitleMissing()
    {
        $this->event->title='';
        $this->event->deleteTranslations();
        $this->event->save();

        $this->assertEquals($this->event->production->title, $this->event->getTitleOrParent());
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

}
