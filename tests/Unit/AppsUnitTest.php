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

        $this->client = Mockery::mock(Client::class)->makePartial();
        $this->contents = Mockery::mock(StreamInterface::class)->makePartial();
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
        $this->client->shouldReceive('get')->andReturn($this->response)->getMock();
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

}