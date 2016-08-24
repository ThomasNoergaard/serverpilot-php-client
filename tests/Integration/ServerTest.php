<?php
use Noergaard\ServerPilot\Client;

class ServerTest extends TestCase
{

    /**
     * @var Client
     */
    private $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = new Client($this->clientId, $this->key);
    }
    
    public function tearDown()
    {
        parent::tearDown();
    }
    
    /**
    * @test
    */
    public function it_lists_all_servers()
    {

        $result = $this->client->servers()->all();

        $this->assertArrayHasKey('name', $result[0]);
        $this->assertArrayHasKey('lastaddress', $result[0]);
        $this->assertEquals($result[0]['name'], 'server-pilot-api-dev');
    }

    /**
    *@test
    */
    public function it_gets_server_by_id()
    {
        $serverId = 'kDOa21hckaa8vfxN';

        $result = $this->client->servers()->get($serverId);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('lastaddress', $result);
        $this->assertEquals($result['name'], 'server-pilot-api-dev');

    }

    /**
    *
    */
    public function it_creates_server_with_name()
    {
        $name = 'new-server';
        $result = $this->client->servers()->create($name);

        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('lastaddress', $result);

    }


    /**
    *@test
    */
    public function it_updates_server_by_id()
    {
        $serverId = 'kDOa21hckaa8vfxN';

        $result = $this->client->servers()->update($serverId, false, false);

        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('lastaddress', $result);
        $this->assertFalse($result['firewall']);
        $this->assertFalse($result['autoupdates']);

        $result = $this->client->servers()->update($serverId);
        $this->assertTrue($result['firewall']);
        $this->assertTrue($result['autoupdates']);
    }

    /**
    *
    */
    public function it_deletes_server_by_id()
    {
        $serverId = $this->client->servers()->all()[0]['id'];
        $result = $this->client->servers()->delete($serverId);
        $this->assertNotEquals($serverId, $this->client->servers()->all()[0]['id']);
    }

}