<?php

namespace Tests\Feature\Api;

use App\Orm\Event;
use App\Orm\OrganizationProduction;
use App\Orm\Place;
use App\Orm\Production;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Tests\Mocks\Vendor\Skagarwal\GooglePlacesApi\GooglePlaces;

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
        $event = Event::factory()->create();

        $response = $this->get($this->getApiUrl() . '/events/' . $event->uid);

        $response->assertStatus(200)
            ->assertJson(['data' => [
                'title' => $event->title,
                'description' => $event->description,
                'place' => [
                    'uid' => $event->place->uid,
                    'name' => GooglePlaces::TEST_PLACE_NAME
                ],
                'times' => [
                    'start' => $event->start_time->toIso8601String(),
                    'end' => $event->end_time->toIso8601String()],
                'production' => ['uid' => $event->production->uid]

            ]]);
    }

    /**
     * @covers \App\Http\Resources\V1\PlaceResource
     */
    public function testEventPlaceExtraFieldsAreEmptyIfPlaceUidNotFound()
    {
        $event = Event::factory()->create();
        $place = Place::factory()->create(['uid' => GooglePlaces::TEST_404_PLACE_UID]);
        $event->place_id = $place->id;
        $event->save();

        $response = $this->get($this->getApiUrl() . '/events/' . $event->uid);

        $response->assertStatus(200)
            ->assertJson(['data' => [
                'title' => $event->title,
                'place' => [
                    'uid' => $event->place->uid
                ]
            ]]);

        $this->assertFalse(stristr($response->getContent(), GooglePlaces::TEST_PLACE_NAME));
    }

    public function testEventScheduleIsReturned()
    {
        Event::factory()->count( 2)->create();

        $response = $this->get($this->getApiUrl() . '/events/schedule');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    public function testPlaceDetailsReturnGoogleMapLinks()
    {
        $this->actingAsLoggedInUser();


        $event = Event::factory()->create();

        $response = $this->get($this->getApiUrl() . '/events/' . $event->uid);

        $response->assertStatus(200);

        $response->json('data.place.staticImage');
        $this->assertEquals(GooglePlaces::TEST_PLACE_URL, $response->json('data.place.urls.maps'));
    }


    public function testEventCanBeCreated()
    {
        $this->actingAsOrganizationMember();

        $production = Production::factory()->create();

        $start = Carbon::now()->addHour();
        $end = Carbon::now()->addHours(2);
        $placeUid = 'ChIJD7fiBh9u5kcRYJSMaMOCCwQ';

        $response = $this->post($this->getApiUrl() . '/events', [
            'times' => [
                'start' => $start->toIso8601String(),
                'end' => $end,
            ],
            'place' => [
                'uid' => $placeUid
            ],
            'production' => ['uid' => $production->uid]
        ]);


        $response->assertStatus(201)
            ->assertJson(['data' => [
                'times' => [
                    'start' => $start->toIso8601String()
                ],
                'place' => [
                    'uid' => $placeUid
                ],
                'production' => ['uid' => $production->uid]]]);

        $this->assertDatabaseHas('events', ['start_time' => $start]);
        $this->assertDatabaseHas('places', ['uid' => $placeUid]);
    }

    public function testEventCanBeEdited()
    {
        $user = $this->actingAsOrganizationMember();
        $event = Event::factory()->create();
        $this->assignEventToUser($event, $user);

        $eventInput = [
            'times' => [
                'start' => '2018-09-13T16:00:00+00:00',
                'end' => '2018-09-13T17:00:00+00:00'
            ],
            'place' => [
                'uid' => 'ChIJD7fiBh9u5kcRYJSMaMOCCwQ'
            ],
            'title' => 'Batman',
            'description' => 'Begins'];

        $response = $this->put($this->getApiUrl() . '/events/' . $event->uid, $eventInput);
        $response->assertStatus(200)
            ->assertJson(['data' => ['times' => $eventInput['times']]]);

        $this->assertDatabaseHas('events', ['start_time' => '2018-09-13 16:00:00']);
        $this->assertDatabaseHas('event_translations', ['title' => 'Batman', 'description' => 'Begins']);
    }

    public function testPlaceCanBeRemovedFromEvent()
    {
        $user = $this->actingAsOrganizationMember();
        $event = Event::factory()->create();
        $this->assignEventToUser($event, $user);

        $eventInput = [
            'times' => [
                'start' => '2018-09-13T16:00:00+00:00',
                'end' => '2018-09-13T17:00:00+00:00'
            ],
            'place' => null,
            'title' => 'Batman',
            'description' => 'Begins'];

        $response = $this->put($this->getApiUrl() . '/events/' . $event->uid, $eventInput);
        $response->assertStatus(200)
            ->assertJson(['data' => ['place' => null]]);

        $this->assertDatabaseHas('event_translations', ['title' => 'Batman', 'description' => 'Begins']);
    }

    public function testEventCanNotBeEditedByNonOwner()
    {
        $this->actingAsOrganizationMember();
        $event = Event::factory()->create();

        $response = $this->put($this->getApiUrl() . '/events/' . $event->uid);
        $response->assertStatus(403);
    }

    public function testEventTitleWillBeSetToNullWhenEmpty()
    {
        $user = $this->actingAsOrganizationMember();
        $event = Event::factory()->create();
        $this->assignEventToUser($event, $user);

        $eventInput = [
            'times' => [
                'start' => '2018-09-13T16:00:00+00:00',
                'end' => '2018-09-13T17:00:00+00:00'
            ],
            'place' => [
                'uid' => 'ChIJD7fiBh9u5kcRYJSMaMOCCwQ'
            ],
            'title' => '', 'description' => 'Bannon'
        ];

        $response = $this->put($this->getApiUrl() . '/events/' . $event->uid, $eventInput);
        $response->assertStatus(200);

        $this->assertDatabaseHas('event_translations', ['title' => null, 'description' => 'Bannon']);
    }

    public function testCanNotDeleteEventNotOwnedByMyOrganizations()
    {
        $this->actingAsOrganizationMember();
        $event = Event::factory()->create();

        $response = $this->delete($this->getApiUrl() . '/events/' . $event->uid);
        $response->assertStatus(403);

    }

    public function testProductionOwnerCanDeleteEvent()
    {
        $user = $this->actingAsOrganizationMember();

        $event = Event::factory()->create();
        $this->assignEventToUser($event, $user);

        $response = $this->delete($this->getApiUrl() . '/events/' . $event->uid);
        $response->assertStatus(200);

    }

    public function testEventImageCanBeRemoved()
    {
        $user = $this->actingAsOrganizationMember();

        $event = Event::factory()->create();
        $this->assignEventToUser($event, $user);

        $eventInput = [
            'times' => [
                'start' => '2018-09-13T16:00:00+00:00',
                'end' => '2018-09-13T17:00:00+00:00'
            ],
            'place' => [
                'uid' => 'ChIJD7fiBh9u5kcRYJSMaMOCCwQ'
            ],
            'images'=>[
                'header'=> [
                    'content' => null
                ]
            ],
            'title' => '',
            'description' => 'Bannon'
        ];

        $response = $this->put($this->getApiUrl() . '/events/' . $event->uid, $eventInput);

        $response->assertStatus(200);
        $this->assertCount(0, $event->getMedia('images'));
    }


    public function testEventImageCanBeAdded()
    {
        $user = $this->actingAsOrganizationMember();

        $event = Event::factory()->create();
        $this->assignEventToUser($event, $user);

        $eventInput = [
            'times' => [
                'start' => '2018-09-13T16:00:00+00:00',
                'end' => '2018-09-13T17:00:00+00:00'
            ],
            'place' => [
                'uid' => 'ChIJD7fiBh9u5kcRYJSMaMOCCwQ'
            ],
            'title' => '', 'description' => 'Bannon',
            'images' => [
                'header' => [
                    'content' => base64_encode(UploadedFile::fake()->image('header.jpg', 900, 506)->get())
                ]
            ]
        ];

        $event->getFirstMedia('images')->delete();

        $response = $this->put($this->getApiUrl() . '/events/' . $event->uid, $eventInput);

        $response->assertStatus(200);
        $this->assertCount(1, $event->getMedia('images'));
        $this->assertEquals('image/png', $event->getFirstMedia('images')->mime_type);
    }
}
