<?php

namespace Tests\Feature\Http\Controllers;

use App\Orm\Event;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Feature\Http\WebTestCase;

/**
 * @package Tests\Feature\Http\Controleers
 * @covers \App\Http\Controllers\EventController
 */
class EventControllerTest extends WebTestCase
{
    use DatabaseMigrations;

    /**
     * Test SEO title of event page
     *
     * The title is shown by Google 'nd stuff, kindof important it has some dynamic elements there
     */
    public function testEventPageTitleHasSeoDescriptiveValues()
    {
        $event = Event::factory()->create();
        $response = $this->get($this->getWebUrl() . 'events/' . $event->uid);
        $this->assertEquals(200,$response->status(),$response->content());

        preg_match("/<title>(.*)<\/title>/im", $response->content(), $matches);

        $this->assertStringContainsString($event->getTitleOrParent(), $matches[1]);
        $this->assertStringContainsString($event->production->organizations()->first()->name, $matches[1]);
        $this->assertStringContainsStringIgnoringCase(config('app.name'), $matches[1]);
    }
}
