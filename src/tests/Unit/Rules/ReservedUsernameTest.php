<?php

namespace Tests\Unit\Rules;

use App\Orm\Tag;
use App\Rules\ReservedUsername;
use App\Rules\TagExists;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

/**
 * @package Tests\Unit\Rules
 * @covers \App\Rules\ReservedUsername
 */
class ReservedUsernameTest extends TestCase
{


    use DatabaseMigrations;

    /**
     * @var TagExists
     */
    protected $validator;

    protected function setUp() : void
    {
        parent::setUp();
        $this->validator = new ReservedUsername;
    }

    public function testEmptyListPasses()
    {
        $this->assertTrue($this->validator->passes('tags', []));
    }

    public function testValidUserNamePasses()
    {

        $this->assertTrue($this->validator->passes('username', 'improviser1234'));
    }

    public function testReservedUsernameDoesNotPass()
    {

        $this->assertFalse($this->validator->passes('username', 'foobar'));
    }
}
