<?php
use Noergaard\ServerPilot\Client;
use Noergaard\ServerPilot\Entities\ActionEntity;

class ActionsTest extends TestCase
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
    public function it_checks_an_action()
    {
        $server = $this->client->servers()->create('testing-actions');
        $entityResult = $this->client->actions()->status($server);

        $this->assertInstanceOf(ActionEntity::class, $entityResult);
        $this->assertEquals($entityResult->id, $server->getActionId());

        $idResult = $this->client->actions()->status($server->getActionId());

        $this->assertInstanceOf(ActionEntity::class, $idResult);
        $this->assertEquals($idResult->id, $server->getActionId());

        $this->client->servers()->delete($server->id);
    }
}
