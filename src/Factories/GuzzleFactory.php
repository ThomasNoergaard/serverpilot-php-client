<?php
namespace Noergaard\ServerPilot\Factories;

use GuzzleHttp\Client;

class GuzzleFactory
{

    private $clientId;
    private $key;
    private $baseUrl = 'https://api.serverpilot.io/v1';


    public function __construct($clientId, $key)
    {
        $this->clientId = $clientId;
        $this->key = $key;
    }

    /**
     * Instantiates GuzzleHttp with base url
     * and authentication
     *
     * @return \GuzzleHttp\Client
     */
    public function createInstance()
    {
        return new Client([

        ]);
    }

    /**
     * Makes instance of GuzzleHttp
     *
     * @param $clientId
     * @param $key
     *
     * @return \GuzzleHttp\Client
     */
    public static function make($clientId, $key)
    {
        return (new static($clientId, $key))->createInstance();
    }
}