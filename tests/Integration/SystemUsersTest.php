<?php
use Noergaard\ServerPilot\Client;

class SystemUsersTest extends TestCase
{

    /**
     * @var Client
     */
    private $client;
    private $serverId;
    private $existingUserId;

    public function setUp()
    {
        parent::setUp();
        $this->client = new Client($this->clientId, $this->key);
        $this->serverId = $this->client->servers()
                                       ->all()[0]['id'];
        $this->existingUserId = '7VVCHTRE7iGiuFZw';
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
        $result = $this->client->systemUsers()->all();
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey('name', $result[0]);
        $this->assertArrayHasKey('serverid', $result[0]);
    }

    /**
     * @test
     */
    public function it_gets_user_by_id()
    {
        $result = $this->client->systemUsers()->get($this->existingUserId);
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('serverid', $result);
    }

    /**
    *
    */
    public function it_creates_a_system_user()
    {
        $name = 'testuser';
        $password = 'password';

        $result = $this->client->systemUsers()->create($this->existingUserId, $name, $password);

        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('serverid', $result);

    }

    /**
    *@test
    */
    public function it_updates_a_user_password_by_id()
    {
        $password = 'password';

        $result = $this->client->systemUsers()->update($this->existingUserId, $password);

        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('serverid', $result);
    }

    /**
    *
    */
    public function it_deletes_a_user_by_id()
    {
        $userId = $this->client->systemUsers()->all()[0]['id'];
        $result = $this->client->systemUsers()->delete($userId);




    }

}