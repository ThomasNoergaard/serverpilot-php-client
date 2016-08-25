<?php
use Noergaard\ServerPilot\Client;
use Noergaard\ServerPilot\Entities\ServerEntity;

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

        $this->assertNotNull($result[0]);
        $this->assertInstanceOf(ServerEntity::class, $result[0]);
    }

    /**
    * @test
    */
    public function it_gets_server_by_id()
    {
        /** @var ServerEntity $server */
        $server = $this->client->servers()->all()[0];

        $result = $this->client->servers()->get($server->id);
        $this->assertInstanceOf(ServerEntity::class, $result);
        $this->assertEquals($server->name, $result->name);
    }

    /**
    * @test
    */
    public function it_creates_updates_and_deletes_server()
    {
        $name = 'new-server';
        $createResult = $this->client->servers()->create($name);
        $this->assertInstanceOf(ServerEntity::class, $createResult);

        $this->assertTrue($createResult->firewall);
        $this->assertTrue($createResult->autoUpdates);
        $updateResult = $this->client->servers()->update($createResult->id, false, false);
        $this->assertFalse($updateResult->firewall);
        $this->assertFalse($updateResult->autoUpdates);

        $deleteResult = $this->client->servers()->delete($createResult->id);
        $this->assertInstanceOf(ServerEntity::class, $deleteResult);
        $this->assertNull($deleteResult->name);
    }
}
