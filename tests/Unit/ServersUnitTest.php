<?php
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery\Mock;
use Noergaard\ServerPilot\Entities\ServerEntity;
use Noergaard\ServerPilot\Resources\Servers;
use Psr\Http\Message\StreamInterface;

class ServersUnitTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Mock
     */
    private $client;

    /**
     * @var Mock
     */
    private $contents;

    /**
     * @var Mock
     */
    private $response;

    /**
     * @var Servers
     */
    private $servers;

    public function setUp()
    {
        parent::setUp();

        $this->client = Mockery::mock(Client::class);
        $this->contents = Mockery::mock(StreamInterface::class);
        $this->response = Mockery::mock(Response::class)->shouldReceive('getBody')->andReturn($this->contents)->getMock();

        $this->servers = new Servers($this->client);
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
        $apiResponse = '{
  "data": [
  {
    "id": "FqHWrrcUfRI18F0l",
    "name": "www1",
    "autoupdates": true,
    "firewall": true,
    "lastaddress": "1.2.3.4",
    "lastconn": 1403130552,
    "datecreated": 1403130551
  }, {
    "id": "4zGDDO2xg30yEeum",
    "name": "vagrant",
    "autoupdates": true,
    "firewall": true,
    "lastaddress": "1.2.3.4",
    "lastconn": 1403130554,
    "datecreated": 1403130553
  }]
}';
        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('get')->with('/v1/servers', [])->andReturn($this->response)->getMock();
        $result =  $this->servers->all();

        $this->assertInstanceOf(ServerEntity::class, $result[0]);
        $this->assertInstanceOf(ServerEntity::class, $result[1]);

        $this->assertEquals('www1', $result[0]->name);
        $this->assertEquals('vagrant', $result[1]->name);
        
    }
    
    /**
    *@test
    */
    public function it_connects_a_server()
    {
        $apiResponse = '{
  "actionid": "tW2fu4hjHnsix6Rn",
  "data":
  {
    "id": "UXOSIYrdtL4cSGp3",
    "name": "www2",
    "autoupdates": true,
    "firewall": true,
    "lastaddress": null,
    "lastconn": null,
    "datecreated": 1403130553,
    "apikey": "nqXUevYSkpW09YKy7CY7PdnL14Q1HIlAfniJZwzjqNQ"
  }
}';
        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('post')->with('/v1/servers', [
            'json' => [
                'name' => 'www2'
            ]
        ])->andReturn($this->response)->getMock();

        $result = $this->servers->create('www2');

        $this->assertEquals('www2', $result->name);
        $this->assertEquals('tW2fu4hjHnsix6Rn', $result->getActionId());
        $this->assertEquals('nqXUevYSkpW09YKy7CY7PdnL14Q1HIlAfniJZwzjqNQ', $result->apiKey);

    }

    /**
    *@test
    */
    public function it_gets_a_server_by_id()
    {
        $apiResponse = '{
  "data":
  {
    "id": "UXOSIYrdtL4cSGp3",
    "name": "www2",
    "autoupdates": true,
    "firewall": true,
    "lastaddress": "1.2.3.4",
    "lastconn": 1403130554,
    "datecreated": 1403130553
  }
}';
        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('get')->with('/v1/servers/UXOSIYrdtL4cSGp3', [])->andReturn($this->response)->getMock();
        
        $result = $this->servers->get('UXOSIYrdtL4cSGp3');
        
        $this->assertEquals('www2', $result->name);
        $this->assertTrue($result->firewall);
        $this->assertTrue($result->autoUpdates);
    }

    /**
    *@test
    */
    public function it_deletes_a_server()
    {
        $apiResponse = '{
  "data": {}
}';
        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('delete')->with('/v1/servers/UXOSIYrdtL4cSGp3', [])->andReturn($this->response)->getMock();

        $result = $this->servers->delete('UXOSIYrdtL4cSGp3');

        $this->assertInstanceOf(ServerEntity::class, $result);
        $this->assertNull($result->name);
    }

    /**
    *@test
    */
    public function it_updates_a_server()
    {
        $apiResponse = '{
  "actionid": "g3kiiYzxPgAjbwcY",
  "data":
  {
    "id": "UXOSIYrdtL4cSGp3",
    "name": "www2",
    "autoupdates": true,
    "firewall": false,
    "lastaddress": "1.2.3.4",
    "lastconn": 1403130554,
    "datecreated": 1403130553
  }
}';
        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('post')->with('/v1/servers/UXOSIYrdtL4cSGp3', [
            'json' => [
                'firewall' => false,
                'autoupdates' => true
            ]
        ])->andReturn($this->response)->getMock();

        $result = $this->servers->update('UXOSIYrdtL4cSGp3',false, true);

        $this->assertFalse($result->firewall);
        $this->assertTrue($result->autoUpdates);
    }

}