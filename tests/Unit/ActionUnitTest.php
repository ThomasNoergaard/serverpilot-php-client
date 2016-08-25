<?php
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery\Mock;
use Noergaard\ServerPilot\Entities\AbstractEntity;
use Noergaard\ServerPilot\Entities\ActionEntity;
use Noergaard\ServerPilot\Resources\Actions;
use Psr\Http\Message\StreamInterface;

class ActionUnitTest extends PHPUnit_Framework_TestCase
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
     * @var Actions
     */
    private $action;

    public function setUp()
    {
        parent::setUp();

        $this->client = Mockery::mock(Client::class);
        $this->contents = Mockery::mock(StreamInterface::class);
        $this->response = Mockery::mock(Response::class)->shouldReceive('getBody')->andReturn($this->contents)->getMock();

        $this->action = new Actions($this->client);
    }
    
    public function tearDown()
    {
        parent::tearDown();
    }
    
    /**
    * @test
    */
    public function it_checks_status_of_action_by_id()
    {
        $apiResponse = '{
  "data":
  {
    "id": "g3kiiYzxPgAjbwcY",
    "serverid": "4zGDDO2xg30yEeum",
    "status": "success",
    "datecreated": 1403138066
  }
}';
        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('get')->with('/v1/actions/g3kiiYzxPgAjbwcY', [])->andReturn($this->response)->getMock();

        $result = $this->action->status('g3kiiYzxPgAjbwcY');

        $this->assertInstanceOf(ActionEntity::class, $result);
        $this->assertEquals('g3kiiYzxPgAjbwcY', $result->getActionId());
    }

    /**
    *@test
    */
    public function it_checks_status_of_action_by_entity()
    {
        $apiResponse = '{
  "data":
  {
    "id": "g3kiiYzxPgAjbwcY",
    "serverid": "4zGDDO2xg30yEeum",
    "status": "success",
    "datecreated": 1403138066
  }
}';
        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('get')->with('/v1/actions/g3kiiYzxPgAjbwcY', [])->andReturn($this->response)->getMock();

        $actionStub = new ActionEntityStub([]);
        $result = $this->action->status($actionStub);

        $this->assertInstanceOf(ActionEntity::class, $result);
        $this->assertEquals('g3kiiYzxPgAjbwcY', $result->getActionId());
    }


}

class ActionEntityStub extends AbstractEntity {

    /**
     * @return array
     */
    protected function mapPropertyNames()
    {
        return [];
    }

    public function getActionId()
    {
        return 'g3kiiYzxPgAjbwcY';
    }

}