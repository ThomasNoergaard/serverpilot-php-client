<?php
use Noergaard\ServerPilot\Client;
use Noergaard\ServerPilot\Factories\DatabaseUserFactory;

class DatabaseTest extends TestCase
{

    /**
     * @var Client
     */
    private $client;
    private $existingId;

    public function setUp()
    {
        parent::setUp();
        $this->client = new Client($this->clientId, $this->key);
        $this->existingId = 'eKFcWtLdqiDTPkJ6';
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
        $result = $this->client->databases()->all();

        $this->assertArrayHasKey('name', $result[0]);
        $this->assertArrayHasKey('appid', $result[0]);
        $this->assertArrayHasKey('serverid', $result[0]);
        $this->assertArrayHasKey('user', $result[0]);
    }

    /**
     * @test
     */
    public function it_gets_database_by_id()
    {
        $result = $this->client->databases()->get($this->existingId);
 
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('appid', $result);
        $this->assertArrayHasKey('serverid', $result);
        $this->assertArrayHasKey('user', $result);
    }
    
    /**
    * @test
    */
    public function it_creates_a_database()
    {
        $appId = $this->client->apps()->all()[0]['id'];
        $databaseName = 'db-from-test';
        $result = $this->client->databases()->create($appId, $databaseName, DatabaseUserFactory::make('test', 'testingtesting'));

        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('appid', $result);
        $this->assertArrayHasKey('serverid', $result);
        $this->assertArrayHasKey('user', $result);
        $this->assertEquals($databaseName, $result['name']);
    }
    
    /**
    *@test
    */
    public function it_updates_password_on_database_by_user_id()
    {
        $databaseUserId = $this->client->databases()->all()[1]['user']['id'];
        $result = $this->client->databases()->updatePassword($this->existingId, $databaseUserId, 'testingtestingtesting');

        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('appid', $result);
        $this->assertArrayHasKey('serverid', $result);
        $this->assertArrayHasKey('user', $result);
    }

    /**
    *@test
    */
    public function it_deletes_a_database()
    {
        $databaseId = $this->client->databases()->all()[0]['id'];

        $result = $this->client->databases()->delete($databaseId);

        $this->assertNotEquals($databaseId, $this->client->databases()->all()[0]['id']);
    }

}