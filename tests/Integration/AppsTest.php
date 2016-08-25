<?php
use Noergaard\ServerPilot\Client;
use Noergaard\ServerPilot\Entities\AppEntity;
use Noergaard\ServerPilot\Factories\WordPressFactory;

class AppsTest extends TestCase
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
    public function it_lists_all_apps()
    {
        $result = $this->client->apps()->all();

        $this->assertInstanceOf(AppEntity::class, $result[0]);
    }

    /**
    *
    */
    public function it_gets_app_by_id()
    {
        $app = $this->client->apps()->all()[0];

        $result = $this->client->apps()->get($app->id);

        $this->assertInstanceOf(AppEntity::class, $result);
        $this->assertEquals($app->name, $result->name);
    }

    /**
    * @test
    */
    public function it_creates_app_without_wordpress_and_deletes_it()
    {
        /** @var AppEntity $app */
        $app = $app = $this->client->apps()->all()[0];
        $name = 'testing-api-dev-'.time();
        $systemUserId = $app->systemUserId;
        $runtime = 'php7.0';
        $domains = ['testing.api.dev.example.com', 'www.testing.api.dev.example.com'];

        $result = $this->client->apps()->create($name, $systemUserId, $runtime, $domains);

        $this->assertInstanceOf(AppEntity::class, $result);

        $this->assertEquals($app->systemUserId, $result->systemUserId);
        $this->assertEquals($name, $result->name);

        $deleteResult = $this->client->apps()->delete($result->id);

        $this->assertInstanceOf(AppEntity::class, $deleteResult);

    }

    /**
     * @test
     */
    public function it_creates_app_with_wordpress_and_deletes_it()
    {
        /** @var AppEntity $app */
        $app = $app = $this->client->apps()->all()[0];

        $name = 'testing-api-dev-with-wordpress';
        $systemUserId = $app->systemUserId;
        $runtime = 'php7.0';
        $domains = ['wordpress.testing.api.dev.example.com', 'www.wordpress.testing.api.dev.example.com'];
        $wordpress = WordPressFactory::make('Test Site', 'test_admin','thisIsATestOfAppCreation', 'john@example.com');

        $result = $this->client->apps()->create($name, $systemUserId, $runtime, $domains, $wordpress);

        $this->assertInstanceOf(AppEntity::class, $result);

        $this->assertEquals($app->systemUserId, $result->systemUserId);
        $this->assertEquals($name, $result->name);

        $deleteResult = $this->client->apps()->delete($result->id);

        $this->assertInstanceOf(AppEntity::class, $deleteResult);
    }

    /**
    * @test
    */
    public function it_creates_app_updates_it_and_deletes_it()
    {
        /** @var AppEntity $app */
        $app = $app = $this->client->apps()->all()[0];
        $name = 'testing-api-dev-'.time();
        $systemUserId = $app->systemUserId;
        $runtime = 'php7.0';
        $domains = ['testing.api.dev.example.com', 'www.testing.api.dev.example.com'];

        $createResult = $this->client->apps()->create($name, $systemUserId, $runtime, $domains);

        $updateRuntime = 'php5.6';
        $updateDomains = ['www.example.com'];

        $updateResult = $this->client->apps()->update($createResult->id, $updateRuntime, $updateDomains);

        $this->assertInstanceOf(AppEntity::class, $updateResult);

        $this->assertEquals($updateResult->runtime, $updateRuntime);
        $this->assertEquals($updateResult->domains, $updateDomains);

        $deleteResult = $this->client->apps()->delete($updateResult->id);

        $this->assertInstanceOf(AppEntity::class, $deleteResult);
    }




}