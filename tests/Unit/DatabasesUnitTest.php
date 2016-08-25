<?php
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery\Mock;
use Noergaard\ServerPilot\Entities\DatabaseEntity;
use Noergaard\ServerPilot\Resources\Databases;
use Noergaard\ServerPilot\ValueObjects\DatabaseUser;
use Psr\Http\Message\StreamInterface;

class DatabasesUnitTest extends PHPUnit_Framework_TestCase
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
     * @var Databases
     */
    private $databases;

    public function setUp()
    {
        parent::setUp();

        $this->client = Mockery::mock(Client::class);
        $this->contents = Mockery::mock(StreamInterface::class);
        $this->response = Mockery::mock(Response::class)->shouldReceive('getBody')->andReturn($this->contents)->getMock();

        $this->databases = new Databases($this->client);
    }
    
    public function tearDown()
    {
        parent::tearDown();
    }
    
    /**
    * @test
    */
    public function it_lists_all_databases()
    {
        $apiResponse = '{
  "data": [
  {
    "id": "hdXkAZchuj27Hm1L",
    "name": "wordpress",
    "appid": "c77JD4gZooGjrF8K",
    "serverid": "4zGDDO2xg30yEeum",
    "user": {
      "id": "vt08Qz9kjOC3RVLr",
      "name": "robert"
    }
  }]
}';
        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('get')->with('/v1/dbs', [])->andReturn($this->response)->getMock();

        $result = $this->databases->all();

        $this->assertInstanceOf(DatabaseEntity::class, $result[0]);
        $this->assertEquals('wordpress', $result[0]->name);

    }

    /**
    *@test
    */
    public function it_creates_a_database()
    {
        $apiResponse = '{
  "actionid": "gPFiWP9hFNUxvT70",
  "data":
  {
    "id": "8PV1OIAlAW3jbGmM",
    "name": "gallerydb",
    "appid": "nlcN0TwdZAyNEgdp",
    "serverid": "4zGDDO2xg30yEeum",
    "user": {
      "id": "k2HWtU33mpUsfOdA",
      "name": "arturo"
    }
  }
}';
        $appId = '8PV1OIAlAW3jbGmM';
        $databaseName = 'gallerydb';
        $databaseUser = new DatabaseUser('arturo', 'some_password');
        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('post')->with('/v1/dbs', [
            'json' => [
                'appid' => $appId,
                'name' => $databaseName,
                'user' => $databaseUser
            ]
        ])->andReturn($this->response)->getMock();

        $result = $this->databases->create($appId, $databaseName, $databaseUser);

        $this->assertInstanceOf(DatabaseEntity::class, $result);
        $this->assertEquals($databaseUser->name, $result->user['name']);

    }

    /**
    *@test
    */
    public function it_gets_database_by_id()
    {
        $apiResponse = '{
  "data":
  {
    "id": "8PV1OIAlAW3jbGmM",
    "name": "gallerydb",
    "appid": "nlcN0TwdZAyNEgdp",
    "serverid": "4zGDDO2xg30yEeum",
    "user": {
      "id": "k2HWtU33mpUsfOdA",
      "name": "arturo"
    }
  }
}';
        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('get')->with('/v1/dbs/8PV1OIAlAW3jbGmM', [])->andReturn($this->response)->getMock();

        $result = $this->databases->get('8PV1OIAlAW3jbGmM');

        $this->assertInstanceOf(DatabaseEntity::class, $result);
        $this->assertEquals('gallerydb', $result->name);
        $this->assertEquals('arturo', $result->user['name']);
    }

    /**
    *@test
    */
    public function it_deletes_database()
    {
        $apiResponse = '{
  "actionid": "AtzNxxz4fZv3zJ9D",
  "data": {}
}';

        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('delete')->with('/v1/dbs/8PV1OIAlAW3jbGmM', [])->andReturn($this->response)->getMock();

        $result = $this->databases->delete('8PV1OIAlAW3jbGmM');

        $this->assertEquals('AtzNxxz4fZv3zJ9D', $result->getActionId());
    }

    /**
    *@test
    */
    public function it_updates_database_user_password()
    {
        $apiResponse = '{
  "actionid": "VfH12ukDJFv0RZAO",
  "data":
  {
    "id": "8PV1OIAlAW3jbGmM",
    "name": "gallerydb",
    "appid": "nlcN0TwdZAyNEgdp",
    "serverid": "4zGDDO2xg30yEeum",
    "user": {
      "id": "k2HWtU33mpUsfOdA",
      "name": "arturo"
    }
  }
}';
        $databaseUser = new \stdClass;
        $databaseUser->id = 'k2HWtU33mpUsfOdA';
        $databaseUser->password = 'some_password';

        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('post')->with('/v1/dbs/8PV1OIAlAW3jbGmM', [
            'json' => [
                'user' => $databaseUser
            ]
        ])->andReturn($this->response)->getMock();

        $result = $this->databases->updatePassword('8PV1OIAlAW3jbGmM', 'k2HWtU33mpUsfOdA', $databaseUser->password);

        $this->assertInstanceOf(DatabaseEntity::class, $result);
        $this->assertEquals('8PV1OIAlAW3jbGmM', $result->id);
    }

}