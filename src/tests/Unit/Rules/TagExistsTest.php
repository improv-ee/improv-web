<?php

namespace Tests\Unit\Rules;

use App\Orm\Organization;
use App\Orm\Tag;
use App\Rules\TagExists;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

/**
 * @package Tests\Unit\Rules
 * @covers \App\Rules\TagExists
 */
class TagExistsTest extends TestCase
{


    use DatabaseMigrations;

    /**
     * @var TagExists
     */
    protected $validator;

    protected function setUp() : void
    {
        parent::setUp();
        $this->validator = new TagExists;
    }

    public function testEmptyListPasses()
    {
        $this->assertTrue($this->validator->passes('tags', []));
    }

    public function testExistingTagPasses()
    {
        $tag = Tag::findFromSlug('tootuba','production');

        $this->assertTrue($this->validator->passes('tags', [
            $tag->slug
        ]));
    }

    public function testListWithInvalidTagFails()
    {
        $tag = Tag::findFromString('etendus','production');

        $this->assertFalse($this->validator->passes('tags', [
            $tag->slug, 'non-existing', $tag->slug
        ]));
    }


    public function testReturnsFalseOnStringInput()
    {
        $this->assertFalse($this->validator->passes('tags', 'Kaladin'));
    }
}
