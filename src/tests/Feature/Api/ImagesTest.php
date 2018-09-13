<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
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
            'response' => $this->post('/api/images', ['image' => $testImage]),
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

        $response->assertJson(['url' => url('storage/images', '', true) . '/' . $response->json()['uid']]);
    }


    public function testUploadedImageIsOptimized()
    {
        $upload = $this->uploadValidImage();
        $uploadedFileSize = $upload['image']->getSize();
        $files = Storage::disk('images')->files();
        $storedFileSize = Storage::disk('images')->size($files[0]);

        $this->assertLessThan(
            $uploadedFileSize,
            $storedFileSize,
            'The file that was stored on disk should be smaller than what was uploaded - the image should have been optimized.'
        );
    }

    public function testTooSmallImageIsRejected()
    {
        $this->actingAsOrganizationMember();
        $testImage = UploadedFile::fake()->image('header.jpg', 50, 60);
        $response = $this->post('/api/images', ['image' => $testImage]);
        $response->assertStatus(422);
    }

    public function testTooLargeImageIsRejected()
    {
        $this->actingAsOrganizationMember();
        $testImage = UploadedFile::fake()->image('header.jpg', 2001, 2001);
        $response = $this->post('/api/images', ['image' => $testImage]);
        $response->assertStatus(422);
    }
}
