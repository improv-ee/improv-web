<?php
namespace Database\Factories\Orm;

use App\Orm\Event;
use App\Orm\Place;
use App\Orm\Production;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $start = $this->faker->dateTimeBetween("-1 day", "+2 months");
        $production = Production::factory()->create();
        $production->addMediaFromBase64(base64_encode(UploadedFile::fake()->image('header.jpg', 900, 506)->get()))
            ->toMediaCollection('images');

        $user = User::factory()->create();

        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(100),
            'start_time' => $start,
            'production_id' =>$production->id,
            'end_time' => Carbon::instance($start)->addHour(),
            'creator_id' => $user->id,
            'place_id' => Place::factory()->create()->id

        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Event $event) {
            // Use a dummy base64 picture for unit tests, but download a larger fancier picture for local dev env
            if (App::environment('testing')) {
                $media = $event->addMediaFromBase64('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAACXBIWXMAAC4jAAAuIwF4pT92AAAAB3RJTUUH4wEbDCgCXDUMQAAAABl0RVh0Q29tbWVudABDcmVhdGVkIHdpdGggR0lNUFeBDhcAAAAMSURBVAjXY/j//z8ABf4C/tzMWecAAAAASUVORK5CYII=');
            } else {
                $media = $event->addMediaFromUrl('https://placekitten.com/600/400');
            }

            $media->toMediaCollection('images');
        });
    }


}
