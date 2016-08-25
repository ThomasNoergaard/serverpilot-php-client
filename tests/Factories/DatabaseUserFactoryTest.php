<?php
use Noergaard\ServerPilot\Factories\DatabaseUserFactory;
use Noergaard\ServerPilot\ValueObjects\DatabaseUser;

class DatabaseUserFactoryTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    
    public function tearDown()
    {
        parent::tearDown();
    }
    
    /**
    * @test
    */
    public function it_creates_an_instance_if_database_user_value_object()
    {
        $databaseUser = DatabaseUserFactory::make('test', 'testtest');

        $this->assertInstanceOf(DatabaseUser::class, $databaseUser);
    }

    /**
    *@test
     * @expectedException Noergaard\ServerPilot\Exceptions\DatabaseUserNameTooLongException
    */
    public function it_throws_an_exception_if_username_is_too_long()
    {
        $databaseUser = DatabaseUserFactory::make('superLongUsernameThatShouldNotWork', 'test');
    }

    /**
    *@test
     * @expectedException Noergaard\ServerPilot\Exceptions\DatabaseUserPasswordNotAcceptableLengthException
    */
    public function it_throws_an_exception_if_password_is_not_eight_characters_or_more()
    {
        $databaseUser = DatabaseUserFactory::make('test', 'test');
    }
}
