<?php
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery\Mock;
use Noergaard\ServerPilot\Entities\SystemUserEntity;
use Noergaard\ServerPilot\Resources\SystemUsers;
use Psr\Http\Message\StreamInterface;

class SystemUserUnitTest extends PHPUnit_Framework_TestCase
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
     * @var SystemUsers
     */
    private $systemUser;

    public function setUp()
    {
        parent::setUp();

        $this->client = Mockery::mock(Client::class);
        $this->contents = Mockery::mock(StreamInterface::class);
        $this->response = Mockery::mock(Response::class)->shouldReceive('getBody')->andReturn($this->contents)->getMock();

        $this->systemUser = new SystemUsers($this->client);
    }
    
    public function tearDown()
    {
        parent::tearDown();
    }
    
    /**
    * @test
    */
    public function it_lists_all_system_users()
    {
        $apiResponse = '{
  "data": [
  {
    "id": "PdmHhsb3fnaZ2r5f",
    "name": "serverpilot",
    "serverid": "FqHWrrcUfRI18F0l"
  },
  {
    "id": "RvnwAIfuENyjUVnl",
    "name": "serverpilot",
    "serverid": "4zGDDO2xg30yEeum"
  }]
}';
        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('get')->with('/v1/sysusers', [])->andReturn($this->response)->getMock();

        $result = $this->systemUser->all();

        $this->assertInstanceOf(SystemUserEntity::class, $result[0]);
        $this->assertInstanceOf(SystemUserEntity::class, $result[1]);

        $this->assertEquals('FqHWrrcUfRI18F0l', $result[0]->serverId);
        $this->assertEquals('4zGDDO2xg30yEeum', $result[1]->serverId);

    }

    /**
    *@test
    */
    public function it_creates_a_system_user()
    {
        $apiResponse = '{
  "actionid": "nnpgQoNzSK11fuTe",
  "data":
  {
    "id": "PPkfc1NECzvwiEBI",
    "name": "derek",
    "serverid": "FqHWrrcUfRI18F0l"
  }
}';
        $serverId = 'FqHWrrcUfRI18F0l';
        $name = 'derek';
        $password = 'some_random_password_that_does_not_matter_in_this_context';

        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('post')->with('/v1/sysusers', [
            'json' => [
                'serverid' => $serverId,
                'name' => $name,
                'password' => $password
            ]
        ])->andReturn($this->response)->getMock();

        $result = $this->systemUser->create($serverId, $name, $password);

        $this->assertInstanceOf(SystemUserEntity::class, $result);
        $this->assertEquals($name, $result->name);

    }

    /**
    *@test
    */
    public function it_gets_a_user_by_id()
    {
        $apiResponse = '{
  "data":
  {
    "id": "PPkfc1NECzvwiEBI",
    "name": "derek",
    "serverid": "FqHWrrcUfRI18F0l"
  }
}';
        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('get')->with('/v1/sysusers/PPkfc1NECzvwiEBI', [])->andReturn($this->response)->getMock();

        $result = $this->systemUser->get('PPkfc1NECzvwiEBI');

        $this->assertInstanceOf(SystemUserEntity::class, $result);
        $this->assertEquals('derek', $result->name);
    }
    
    /**
    *@test
    */
    public function it_deletes_a_system_user_by_id()
    {
        $apiResponse = '{
  "actionid": "9tvygrrXZulYuizz",
  "data": {}
}';
        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('delete')->with('/v1/sysusers/PPkfc1NECzvwiEBI', [])->andReturn($this->response)->getMock();

        $result = $this->systemUser->delete('PPkfc1NECzvwiEBI');

        $this->assertInstanceOf(SystemUserEntity::class, $result);
        $this->assertEquals('9tvygrrXZulYuizz', $result->getActionId());
    }

    /**
    *@test
    */
    public function it_updates_system_user()
    {
        $apiResponse = '{
  "actionid": "OF42xCWkKcaX3qG2",
  "data":
  {
    "id": "RvnwAIfuENyjUVnl",
    "name": "serverpilot",
    "serverid": "4zGDDO2xg30yEeum"
  }
}';
        $password = 'some_new_password';
        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('post')->with('/v1/sysusers/RvnwAIfuENyjUVnl', [
            'json' => [
                'password' => $password
            ]
        ])->andReturn($this->response)->getMock();

        $result = $this->systemUser->update('RvnwAIfuENyjUVnl', $password);

        $this->assertInstanceOf(SystemUserEntity::class, $result);
    }

}