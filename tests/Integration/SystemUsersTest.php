<?php
use Noergaard\ServerPilot\Client;
use Noergaard\ServerPilot\Entities\ServerEntity;
use Noergaard\ServerPilot\Entities\SystemUserEntity;

class SystemUsersTest extends TestCase
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
    public function it_lists_all_system_users()
    {
        $result = $this->client->systemUsers()->all();

        $this->assertInstanceOf(SystemUserEntity::class, $result[0]);
    }

    /**
     * @test
     */
    public function it_gets_user_by_id()
    {
        /** @var SystemUserEntity $systemUser */
        $systemUser = $this->client->systemUsers()->all()[0];
        $result = $this->client->systemUsers()->get($systemUser->id);

        $this->assertInstanceOf(SystemUserEntity::class, $result);
        $this->assertEquals($systemUser->name, $result->name);
    }

    /*
    * Only works if you are on payed plan
    *
    */
    public function it_creates_a_system_user_updates_it_and_deletes_it()
    {
        /** @var ServerEntity $server */
        $server = $this->client->servers()->all()[0];

        $name = 'testuser';
        $password = 'password';
        $createResult = $this->client->systemUsers()->create($server->id, $name, $password);

        $this->assertInstanceOf(SystemUserEntity::class, $createResult);
        $this->assertEquals($name, $createResult->name);

        $newPassword = 'newpassword';
        $updateResult = $this->client->systemUsers()->update($createResult->id, $newPassword);

        $this->assertInstanceOf(SystemUserEntity::class, $updateResult);
        $this->assertEquals($name, $updateResult->name);

        $deleteResult = $this->client->systemUsers()->delete($updateResult->id);
        $this->assertInstanceOf(SystemUserEntity::class, $deleteResult);
        $this->assertNull($deleteResult->name);

    }
}