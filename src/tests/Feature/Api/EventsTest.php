<?php

namespace Tests\Feature\Api;

use App\Orm\Event;
use App\Orm\OrganizationProduction;
use App\Orm\Production;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * @package Tests\Feature\Api
 * @covers \App\Http\Controllers\Api\V1\EventController
 */
class EventsTest extends ApiTestCase
{
    use DatabaseMigrations;

    protected function assignEventToUser(Event $event, User $user)
    {
        return $event->production->organizations()->attach($user->organizations()->first());
    }

    public function testEventInfoIsReturned()
    {
        $event = factory(Event::class)->create();

        $response = $this->get($this->getApiUrl() . '/events/' . $event->uid);

        $response->assertStatus(200)
            ->assertJson(['data' => [
                'title' => $event->title,
                'description' => $event->description,
                'times' => [
                    'start' => $event->start_time->toIso8601String(),
                    'end' => $event->end_time->toIso8601String()],
                'production' => ['slug' => $event->production->slug]

            ]]);
    }


    public function testEventScheduleIsReturned()
    {
        factory(Event::class, 2)->create();

        $response = $this->get($this->getApiUrl() . '/events/schedule');

        $response->assertStatus(200)
            ->assertJsonCount(2,'data');
    }

    public function testEventCanBeCreated()
    {
        $this->actingAsOrganizationMember();

        $production = factory(Production::class)->create();

        $start = Carbon::now()->addHour();
        $end = Carbon::now()->addHours(2);
        $response = $this->post($this->getApiUrl() . '/events', [
            'times' => [
                'start' => $start->toIso8601String(),
                'end' => $end,
            ],
            'production' => ['slug' => $production->slug]
        ]);

        $response->assertStatus(201)
            ->assertJson(['data' => ['times' => ['start' => $start->toIso8601String()],
                'production' => ['slug' => $production->slug]]]);

        $this->assertDatabaseHas('events', ['start_time' => $start]);
    }

    public function testEventCanBeEdited()
    {
        $user = $this->actingAsOrganizationMember();
        $event = factory(Event::class)->create();
        $this->assignEventToUser($event, $user);

        $eventInput = ['times' => ['start' => '2018-09-13T16:00:00+00:00', 'end' => '2018-09-13T17:00:00+00:00'],
            'title' => 'Batman',
            'description' => 'Begins'];

        $response = $this->put($this->getApiUrl() . '/events/' . $event->uid, $eventInput);
        $response->assertStatus(200)
            ->assertJson(['data' => ['times' => $eventInput['times']]]);

        $this->assertDatabaseHas('events', ['start_time' => '2018-09-13 16:00:00']);
        $this->assertDatabaseHas('event_translations', ['title' => 'Batman', 'description' => 'Begins']);
    }

    public function testEventCanNotBeEditedByNonOwner()
    {
        $this->actingAsOrganizationMember();
        $event = factory(Event::class)->create();

        $response = $this->put($this->getApiUrl() . '/events/' . $event->uid);
        $response->assertStatus(403);
    }

    public function testEventTitleWillBeSetToNullWhenEmpty()
    {
        $user = $this->actingAsOrganizationMember();
        $event = factory(Event::class)->create();
        $this->assignEventToUser($event, $user);

        $eventInput = ['times' => ['start' => '2018-09-13T16:00:00+00:00', 'end' => '2018-09-13T17:00:00+00:00'],
            'title' => '', 'description' => 'Bannon'];

        $response = $this->put($this->getApiUrl() . '/events/' . $event->uid, $eventInput);
        $response->assertStatus(200);

        $this->assertDatabaseHas('event_translations', ['title' => null, 'description' => 'Bannon']);
    }

    public function testCanNotDeleteEventNotOwnedByMyOrganizations()
    {
        $this->actingAsOrganizationMember();
        $event = factory(Event::class)->create();

        $response = $this->delete($this->getApiUrl() . '/events/' . $event->uid);
        $response->assertStatus(403);

    }

    public function testProductionOwnerCanDeleteEvent()
    {
        $user = $this->actingAsOrganizationMember();

        $event = factory(Event::class)->create();
        $this->assignEventToUser($event, $user);

        $response = $this->delete($this->getApiUrl() . '/events/' . $event->uid);
        $response->assertStatus(200);

    }
}
