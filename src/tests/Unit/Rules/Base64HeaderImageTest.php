<?php

namespace Tests\Unit\Rules;

use App\Rules\Base64HeaderImage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

/**
 * @package Tests\Unit\Rules
 * @covers \App\Rules\Base64HeaderImage
 */
class Base64HeaderImageTest extends TestCase
{
    /**
     * @var Base64HeaderImage
     */
    protected $validator;

    protected function setUp() : void
    {
        parent::setUp();
        $this->validator = new Base64HeaderImage;
    }

    public function testValidImagePasses()
    {
        $image = base64_encode(UploadedFile::fake()->image('header.jpg', 900, 506)->get());
        $this->assertTrue($this->validator->passes('image', $image));
    }

    public function testTooSmallHeaderDoesNotPass()
    {
        $image = base64_encode(UploadedFile::fake()->image('header.jpg', 100, 506)->get());
        $this->assertFalse($this->validator->passes('image', $image));
    }

    public function testPdfIsNotAccepted()
    {
        $pdf = base64_encode(file_get_contents(base_path('tests/fixtures/images/not-image.pdf')));
        $this->assertFalse($this->validator->passes('image', $pdf));
    }

    public function testInvalidFileTypeIsNotAccepted()
    {
        $text = 'VGhpcyBpcyBub3QgYW4gaW1hZ2UuIFVzZWQgYXMgaW5wdXQgdG8gdGVzdCBpbWFnZSB2YWxpZGF0b3JzLgo=';
        $this->assertFalse($this->validator->passes('image', $text));
    }
}
