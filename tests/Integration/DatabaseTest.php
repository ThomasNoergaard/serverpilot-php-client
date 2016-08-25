<?php
use Noergaard\ServerPilot\Client;
use Noergaard\ServerPilot\Entities\AppEntity;
use Noergaard\ServerPilot\Entities\DatabaseEntity;
use Noergaard\ServerPilot\Factories\DatabaseUserFactory;

class DatabaseTest extends TestCase
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
    public function it_lists_all_databases()
    {
        $result = $this->client->databases()->all();

        $this->assertInstanceOf(DatabaseEntity::class, $result[0]);
    }

    /**
     * @test
     */
    public function it_gets_database_by_id()
    {
        $database = $this->client->databases()->all()[0];
        $result = $this->client->databases()->get($database->id);

        $this->assertInstanceOf(DatabaseEntity::class, $result);
        $this->assertEquals($database->name, $result->name);
    }
    
    /**
    * @test
    */
    public function it_creates_a_database_updates_its_password_and_deletes_it()
    {
        /** @var AppEntity $app */
        $app = $this->client->apps()->all()[0];

        $databaseName = 'db-from-test';
        $createResult = $this->client->databases()->create($app->id, $databaseName, DatabaseUserFactory::make('test', 'testingtesting'));

        $this->assertInstanceOf(DatabaseEntity::class, $createResult);
        $this->assertEquals($databaseName, $createResult->name);

        $updateResult = $this->client->databases()->updatePassword($createResult->id, $createResult->user['id'], 'testingtestingtesting');

        $this->assertInstanceOf(DatabaseEntity::class, $updateResult);

        $deleteResult = $this->client->databases()->delete($updateResult->id);

        $this->assertInstanceOf(DatabaseEntity::class, $deleteResult);
        $this->assertNull($deleteResult->name);

    }
    
    /**
    *
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
    *
    */
    public function it_deletes_a_database()
    {
        $databaseId = $this->client->databases()->all()[0]['id'];

        $result = $this->client->databases()->delete($databaseId);

        $this->assertNotEquals($databaseId, $this->client->databases()->all()[0]['id']);
    }

}