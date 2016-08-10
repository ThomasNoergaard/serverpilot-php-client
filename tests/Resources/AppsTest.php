<?php
use Noergaard\ServerPilot\Client;
use Noergaard\ServerPilot\Factories\WordPressFactory;

class AppsTest extends TestCase
{

    /**
     * @var Client
     */
    private $client;

    private $appId;
    private $wordPressAppId;
    private $existinAzppId;

    public function setUp()
    {
        parent::setUp();

        $this->client = new Client($this->clientId, $this->key);
        $this->existinAzppId = 's8QuaiOMd6vDdsBm';
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

        $this->assertArrayHasKey('name', $result[0]);
        $this->assertArrayHasKey('domains', $result[0]);
        $this->assertArrayHasKey('serverid', $result[0]);
        $this->assertArrayHasKey('runtime', $result[0]);
    }

    /**
    *@test
    */
    public function it_gets_app_by_id()
    {
        $appId = $this->existinAzppId;

        $result = $this->client->apps()->get($appId);

        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('domains', $result);
        $this->assertArrayHasKey('serverid', $result);
        $this->assertArrayHasKey('runtime', $result);
    }

    /**
    * @test
    */
    public function it_creates_app_without_wordpress()
    {
        $name = 'testing-api-dev';
        $systemUserId = '7VVCHTRE7iGiuFZw';
        $runtime = 'php7.0';
        $domains = ['testing.api.dev.example.com', 'www.testing.api.dev.example.com'];

        $result = $this->client->apps()->create($name, $systemUserId, $runtime, $domains);

        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('domains', $result);
        $this->assertArrayHasKey('serverid', $result);
        $this->assertArrayHasKey('runtime', $result);

        $this->assertEquals($result['name'], $name);
        $this->assertEquals($result['sysuserid'], $systemUserId);
        $this->assertEquals($result['runtime'], $runtime);

    }

    /**
     * @test
     */
    public function it_creates_app_with_wordpress()
    {
        $name = 'testing-api-dev-with-wordpress';
        $systemUserId = '7VVCHTRE7iGiuFZw';
        $runtime = 'php7.0';
        $domains = ['wordpress.testing.api.dev.example.com', 'www.wordpress.testing.api.dev.example.com'];
        $wordpress = WordPressFactory::make('Test Site', 'test_admin','thisIsATestOfAppCreation', 'tgn@wackystudio.com');

        $result = $this->client->apps()->create($name, $systemUserId, $runtime, $domains, $wordpress);

        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('domains', $result);
        $this->assertArrayHasKey('serverid', $result);
        $this->assertArrayHasKey('runtime', $result);

        $this->assertEquals($result['name'], $name);
        $this->assertEquals($result['sysuserid'], $systemUserId);
        $this->assertEquals($result['runtime'], $runtime);
    }

    /**
    *@test
    */
    public function it_updates_app()
    {
        $appId = $this->existinAzppId;
        $runtime = 'php5.6';
        $domains = ['www.example.com'];

        $result = $this->client->apps()->update($appId, $runtime, $domains);

        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('domains', $result);
        $this->assertArrayHasKey('serverid', $result);
        $this->assertArrayHasKey('runtime', $result);

        $this->assertEquals($result['runtime'], $runtime);
        $this->assertEquals($result['domains'], $domains);

        $result = $this->client->apps()->update($appId, 'php7.0', ['example.com']);
        $this->assertEquals($result['runtime'], 'php7.0');
        $this->assertEquals($result['domains'], ['example.com']);
    }

    /**
    *@test
    */
    public function it_deletes_app()
    {

        $appId = $this->client->apps()->all()[0]['id'];

        $result = $this->client->apps()->delete($appId);

        $this->assertNotEquals($this->client->apps()->all()[0]['id'], $appId);

        // Clean up
        $appId = $this->client->apps()->all()[0]['id'];

        $result = $this->client->apps()->delete($appId);

        $this->assertNotEquals($this->client->apps()->all()[0]['id'], $appId);

    }



}