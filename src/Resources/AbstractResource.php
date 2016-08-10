<?php
namespace Noergaard\ServerPilot\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

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

    /**
     * Perform GET request
     *
     * @param $uri
     * @param array $options
     *
     * @return array
     */
    public function getRequest($uri, $options = [])
    {
        try{
            $response = $this->client->get(sprintf('/v1%s',$uri),$options);
            return $this->parseJsonToArray($response->getBody()->getContents())['data'];
        }catch (ClientException $e)
        {
            dd($e->getResponse()->getBody()->getContents());
        }
    }

    /**
     * Perform POST request
     *
     * @param $uri
     * @param array $data
     * @param array $options
     *
     * @return array
     */
    public function postRequest($uri, $data = [] ,$options = [])
    {
        $options = collect(['json' => $data])->merge(collect($options))->toArray();

        try{
            $response = $this->client->post(sprintf('/v1%s',$uri), $options);
            return $this->parseJsonToArray($response->getBody()->getContents())['data'];
        }catch (ClientException $e)
        {
            dd($e->getResponse()->getBody()->getContents());
        }
    }

    public function deleteRequest($uri, $options = [])
    {
        try{
            $response = $this->client->delete(sprintf('/v1%s',$uri),$options);
            return $this->parseJsonToArray($response->getBody()->getContents())['data'];
        }catch (ClientException $e)
        {
            dd($e->getResponse()->getBody()->getContents());
        }
    }

    /**
     * Parse response json to associative array
     *
     * @param $content
     *
     * @return array
     */
    public function parseJsonToArray($content)
    {
        return json_decode($content, true);
    }

    /**
     * Formats string to lowercase and dashes instead of spaces
     *
     * @param $string
     *
     * @return string
     */
    public function formatStringToLowercaseAndDashes($string)
    {
        return strtolower(str_replace(' ','-',$string));
    }
}