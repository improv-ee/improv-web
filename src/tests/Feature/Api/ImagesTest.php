<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class ImagesTest extends ApiTestCase
{
    use DatabaseMigrations;


    protected function uploadValidImage()
    {
        Storage::fake('images');

        $this->actingAsOrganizationMember();

        $testImage = UploadedFile::fake()->image('header.jpg', 800, 400);

        return [
            'response' => $this->post($this->getApiUrl() . '/images', ['image' => $testImage]),
            'image' => $testImage
        ];
    }

    public function testImageCanBeUploaded()
    {
        $upload = $this->uploadValidImage();
        $upload['response']->assertStatus(201);

        $this->assertDatabaseHas('images', ['filename' => 'header.jpg']);
    }

    public function testImageURLIsReturnedOnUpload()
    {
        $upload = $this->uploadValidImage();
        $response = $upload['response'];

        $expectedUrl =$this->getApiUrl().'/images/'.$response->json()['uid'];

        // $this->getWebUrl().'/storage/images/' . $response->json()['uid']
        $response->assertJson(['url' =>$expectedUrl]);
    }


    public function testTooSmallImageIsRejected()
    {
        $this->actingAsOrganizationMember();
        $testImage = UploadedFile::fake()->image('header.jpg', 50, 60);
        $response = $this->post($this->getApiUrl() . '/images', ['image' => $testImage]);
        $response->assertStatus(422);
    }

    public function testTooLargeImageIsRejected()
    {
        $this->actingAsOrganizationMember();
        $testImage = UploadedFile::fake()->image('header.jpg', 2001, 2001);
        $response = $this->post($this->getApiUrl() . '/images', ['image' => $testImage]);
        $response->assertStatus(422);
    }
}
