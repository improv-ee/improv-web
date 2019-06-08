<?php

namespace App\Console\Commands;

use App\Orm\Event;
use App\Orm\Organization;
use App\Orm\OrganizationUser;
use App\Orm\Production;
use App\User;
use Illuminate\Console\Command;
use Spatie\MediaLibrary\Models\Media;

class SeedApiDoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apidoc:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with sample data for API doc generation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        factory(User::class, 5)->create();
        $user = factory(User::class)->create(['username' => 'rahel']);

        factory(Organization::class, 5)->create();
        $organization = factory(Organization::class)->create(['slug' => 'jaa', 'name' => 'Jaa']);

        $member = new OrganizationUser;
        $member->user_id = $user->id;
        $member->organization_id = $organization->id;
        $member->role = OrganizationUser::ROLE_MEMBER;
        $member->creator_id = $user->id;
        $member->save();


        factory(Event::class, 5)->create();
        factory(Event::class)->create(['uid' => 'amv9z6a23']);
        factory(Production::class, 5)->create();
        factory(Production::class)->create();
        factory(OrganizationUser::class, 3)->create();
        factory(Media::class, 3)->create();

        // "Login" the newly created user and get an API token for her
        // Output the token for usage in the API doc generator
        $this->line($user->createToken('apiDoc')->accessToken);
    }
}
