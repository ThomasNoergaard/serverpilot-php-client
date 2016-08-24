<?php
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery\Mock;
use Noergaard\ServerPilot\Entities\AppEntity;
use Noergaard\ServerPilot\Entities\SslEntity;
use Noergaard\ServerPilot\Resources\Apps;
use Psr\Http\Message\StreamInterface;

class AppsUnitTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Mock
     */
    private $client;

    /**
     * @var Apps
     */
    private $apps;

    /**
     * @var Mock
     */
    private $contents;

    /**
     * @var Mock
     */
    private $response;

    public function setUp()
    {
        parent::setUp();

        $this->client = Mockery::mock(Client::class);
        $this->contents = Mockery::mock(StreamInterface::class);
        $this->response = Mockery::mock(Response::class)->shouldReceive('getBody')->andReturn($this->contents)->getMock();
        $this->apps = new Apps($this->client);
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
        $apiResponse = '{
  "data": [
  {
    "id": "c77JD4gZooGjrF8K",
    "name": "blog",
    "sysuserid": "RvnwAIfuENyjUVnl",
    "domains": ["www.myblog.com", "blog.com"],
    "ssl": null,
    "serverid": "4zGDDO2xg30yEeum",
    "runtime": "php7.0"
  },
  {
    "id": "B1w7yc1tfUPQLIKS",
    "name": "store",
    "sysuserid": "RvnwAIfuENyjUVnl",
    "domains": ["www.mystore.com", "mystore.com"],
    "ssl": {
      "key": "-----BEGIN PRIVATE KEY----- ...",
      "cert": "-----BEGIN CERTIFICATE----- ...",
      "cacerts": "-----BEGIN CERTIFICATE----- ...",
      "auto": false,
      "force": false
    },
    "serverid": "4zGDDO2xg30yEeum",
    "runtime": "php7.0"
  }]
}';
        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('get')->with('/v1/apps', [])->andReturn($this->response)->getMock();
        $result = $this->apps->all();

        $this->assertTrue(is_array($result));
        $this->assertInstanceOf(AppEntity::class, $result[0]);

        /** @var AppEntity $firstApp */
        $firstApp = $result[0];

        $this->assertEquals('c77JD4gZooGjrF8K', $firstApp->id);
        $this->assertEquals('blog', $firstApp->name);
        $this->assertEquals('RvnwAIfuENyjUVnl', $firstApp->systemUserId);
        $this->assertEquals(["www.myblog.com", "blog.com"], $firstApp->domains);
        $this->assertNull($firstApp->ssl);
        $this->assertEquals('4zGDDO2xg30yEeum', $firstApp->serverId);
        $this->assertEquals('php7.0', $firstApp->runtime);

        $secondApp = $result[1];

        $this->assertInstanceOf(SslEntity::class, $secondApp->ssl);
        $this->assertEquals("-----BEGIN PRIVATE KEY----- ...", $secondApp->ssl->key);

    }

    /**
    * @test
    */
    public function it_creates_an_app()
    {
        $name = 'gallery';
        $systemUserId = 'RvnwAIfuENyjUVnl';
        $domains = [
            'www.example.com',
            'example.com'
        ];

        $runtime = 'php7.0';

        $apiResponse = '{
  "actionid": "dIrCNoWunW92lPjw",
  "data":
  {
    "id": "nlcN0TwdZAyNEgdp",
    "name": "gallery",
    "sysuserid": "RvnwAIfuENyjUVnl",
    "domains": ["www.example.com", "example.com"],
    "ssl": null,
    "serverid": "4zGDDO2xg30yEeum",
    "runtime": "php7.0"
  }
}';

        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('post')->with('/v1/apps', [
            'json' => [
                'name' => $name,
                'sysuserid' => $systemUserId,
                'runtime' => $runtime,
                'domains' => $domains,
            ]
        ])->andReturn($this->response)->getMock();
        /** @var AppEntity $result */
        $result = $this->apps->create($name, $systemUserId, $runtime, $domains);

        $this->assertEquals('dIrCNoWunW92lPjw', $result->getActionId());
        $this->assertEquals($name, $result->name);
        $this->assertEquals($systemUserId, $result->systemUserId);

    }

    /**
    *@test
    */
    public function it_gets_an_app_by_id()
    {
        $apiResponse = '{
  "data":
  {
    "id": "nlcN0TwdZAyNEgdp",
    "name": "gallery",
    "sysuserid": "RvnwAIfuENyjUVnl",
    "domains": ["www.example.com", "example.com", "foo.com"],
    "ssl": {
      "key": "-----BEGIN PRIVATE KEY----- ... -----END PRIVATE KEY-----",
      "cert": "-----BEGIN CERTIFICATE----- ... -----END CERTIFICATE-----",
      "cacerts": "-----BEGIN CERTIFICATE----- ... -----END CERTIFICATE-----",
      "auto": false,
      "force": false
    },
    "autossl": {
      "available": true,
      "domains": ["www.example.com", "example.com"]
    },
    "serverid": "4zGDDO2xg30yEeum",
    "runtime": "php7.0"
  }
}';
        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('get')->with('/v1/apps/nlcN0TwdZAyNEgdp', [])->andReturn($this->response)->getMock();

        /** @var AppEntity $result */
        $result = $this->apps->get('nlcN0TwdZAyNEgdp');

        $this->assertEquals('4zGDDO2xg30yEeum', $result->serverId);
    }

    /**
    *@test
    */
    public function it_deletes_an_app()
    {
        $apiResponse = '{
  "actionid": "88Ypexhx28Y63eyA",
  "data": {}
}';
        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('delete')->with('/v1/apps/nlcN0TwdZAyNEgdp', [])->andReturn($this->response)->getMock();

        /** @var AppEntity $result */
        $result = $this->apps->delete('nlcN0TwdZAyNEgdp');

        $this->assertNull($result->name);
        $this->assertEquals('88Ypexhx28Y63eyA', $result->getActionId());

    }

    /**
    *@test
    */
    public function it_updates_an_app()
    {
        $apiResponse = '{
  "actionid": "KlsNzLikw3BRvShc",
  "data":
  {
    "id": "nlcN0TwdZAyNEgdp",
    "name": "gallery",
    "sysuserid": "RvnwAIfuENyjUVnl",
    "domains": ["www.example.com", "example.com"],
    "ssl": null,
    "serverid": "4zGDDO2xg30yEeum",
    "runtime": "php5.6"
  }
}';
        $runtime = 'php5.6';
        $domains = ['www.example.com', 'example.com'];

        $this->contents->shouldReceive('getContents')->andReturn($apiResponse)->getMock();
        $this->client->shouldReceive('post')->with('/v1/apps/nlcN0TwdZAyNEgdp', [
            'json' => [
                'runtime' => $runtime,
                'domains' => $domains,
            ]
        ])->andReturn($this->response)->getMock();

        $result = $this->apps->update('nlcN0TwdZAyNEgdp', $runtime, $domains);

        $this->assertEquals($runtime, $result->runtime);
        $this->assertEquals($domains, $result->domains);
    }

}