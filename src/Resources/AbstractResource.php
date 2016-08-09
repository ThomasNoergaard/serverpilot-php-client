<?php
namespace Noergaard\ServerPilot\Resources;

use GuzzleHttp\Client;

abstract class AbstractResource
{

    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}