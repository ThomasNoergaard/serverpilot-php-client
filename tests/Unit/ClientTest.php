<?php
use Noergaard\ServerPilot\Client;
use Noergaard\ServerPilot\Resources\Actions;
use Noergaard\ServerPilot\Resources\Apps;
use Noergaard\ServerPilot\Resources\Databases;
use Noergaard\ServerPilot\Resources\Servers;
use Noergaard\ServerPilot\Resources\SystemUsers;

class ClientTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Client
     */
    private $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = new Client('client', 'key');
    }
    
    public function tearDown()
    {
        parent::tearDown();
    }
    
    /**
    * @test
    */
    public function it_makes_instance_of_action_resource()
    {
        $this->assertInstanceOf(Actions::class, $this->client->actions());
    }

    /**
    *@test
    */
    public function it_makes_instance_if_apps()
    {
        $this->assertInstanceOf(Apps::class, $this->client->apps());
    }

    /**
    *@test
    */
    public function it_makes_instance_of_databases()
    {
        $this->assertInstanceOf(Databases::class, $this->client->databases());
    }

    /**
    *@test
    */
    public function it_makes_instance_of_servers()
    {
        $this->assertInstanceOf(Servers::class, $this->client->servers());
    }

    /**
    *@test
    */
    public function it_makes_instance_of_system_users()
    {
        $this->assertInstanceOf(SystemUsers::class, $this->client->systemUsers());
    }
}
