<?php
use Noergaard\ServerPilot\Client;

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
        $result = $this->client->actions()->status('asdasdasda');

        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('serverid', $result);
        $this->assertArrayHasKey('datecreated', $result);
    }

}