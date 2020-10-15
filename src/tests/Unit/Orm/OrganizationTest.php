<?php

namespace Tests\Unit\Filters;

use App\Orm\Organization;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use JoggApp\GoogleTranslate\GoogleTranslate;
use Mockery;
use Tests\TestCase;

class OrganizationTest extends TestCase
{

    use DatabaseMigrations;

    public function testAmMemberReturnsTrueIfUserIsMember()
    {

        $user = $this->actingAsLoggedInUser();
        $organization = Organization::factory()->create();
        $organization->users()->attach($user, ['creator_id' => $user->id]);

        $this->assertTrue($organization->isMember($user));
    }

    public function testAmMemberReturnsFalseIfUserIsNotMember()
    {

        $user = $this->actingAsLoggedInUser();
        $organization = Organization::factory()->create();

        $this->assertFalse($organization->isMember($user));
    }


    public function testOrganizationCreationInForeignLanguageSavesDefaultEnglishTranslation()
    {

        /** @var \Mockery\MockInterface $mockClient */
        $mockClient = $this->mock(GoogleTranslate::class);
        $mockClient->shouldReceive('justTranslate')->atLeast()->times(2)
            ->andReturnUsing(function ($inputText) {
                return 'translated-' . $inputText;
            });

        $organization = Organization::factory()->create();

        $defaultLocale = config('app.fallback_locale');

        $this->assertEquals('translated-' . $organization->name, $organization->translate($defaultLocale)->name);
        $this->assertEquals('translated-' . $organization->description, $organization->translate($defaultLocale)->description);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

}
