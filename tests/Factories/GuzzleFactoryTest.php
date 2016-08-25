<?php
use Noergaard\ServerPilot\Factories\GuzzleFactory;

class GuzzleFactoryTest extends TestCase
{
    /**
    *@test
    */
    public function it_instantiates_an_instance_of_guzzle()
    {
        $guzzle = GuzzleFactory::make($this->clientId, $this->key);

        $this->assertInstanceOf(GuzzleHttp\Client::class, $guzzle);
    }

    /**
    * @test
    */
    public function it_instantiates_guzzle_with_correct_base_uri()
    {
        $baseUri = 'https://api.serverpilot.io/v1';

        $guzzle = GuzzleFactory::make($this->clientId, $this->key);

        $guzzleBaseUri = $guzzle->getConfig('base_uri');
        $this->assertEquals($baseUri, $guzzleBaseUri->getScheme() . '://' . $guzzleBaseUri->getHost() . $guzzleBaseUri->getPath());
    }

    /**
    *@test
    */
    public function it_instantiates_guzzle_with_basic_auth_using_client_id_and_key()
    {
        $guzzle = GuzzleFactory::make($this->clientId, $this->key);

        $auth = $guzzle->getConfig('auth');

        $this->assertEquals($this->clientId, $auth[0]);
        $this->assertEquals($this->key, $auth[1]);
    }
}
