<?php
namespace Noergaard\ServerPilot\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Noergaard\ServerPilot\Entities\AbstractEntity;
use Noergaard\ServerPilot\Entities\AppEntity;
use Noergaard\ServerPilot\Exceptions\ServerPilotException;

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
     * @throws ServerPilotException
     */
    public function getRequest($uri, $options = [])
    {
        try{
            $response = $this->client->get(sprintf('/v1%s',$uri),$options);
        }catch (ClientException $e)
        {
            $this->handleExceptions($e);
        }catch (RequestException $e)
        {
            $this->handleExceptions($e);
        }

        return $this->parseJsonToArray($response->getBody()->getContents());
    }

    /**
     * Perform POST request
     *
     * @param $uri
     * @param array $data
     * @param array $options
     *
     * @return array
     * @throws ServerPilotException
     */
    public function postRequest($uri, $data = [] ,$options = [])
    {
        $options = collect(['json' => $data])->merge(collect($options))->toArray();

        try{
            $response = $this->client->post(sprintf('/v1%s',$uri), $options);
        }catch (ClientException $e)
        {
            $this->handleExceptions($e);
        }catch (RequestException $e)
        {
            $this->handleExceptions($e);
        }

        return $this->parseJsonToArray($response->getBody()->getContents());
    }

    /**
     * Perform DELETE request
     *
     * @param $uri
     * @param array $options
     *
     * @return mixed
     * @throws ServerPilotException
     */
    public function deleteRequest($uri, $options = [])
    {
        try{
            $response = $this->client->delete(sprintf('/v1%s',$uri),$options);
        }catch (ClientException $e)
        {
            $this->handleExceptions($e);
        }catch (RequestException $e)
        {
            $this->handleExceptions($e);
        }

        return $this->parseJsonToArray($response->getBody()->getContents());
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

    /**
     * @param $e
     *
     * @throws ServerPilotException
     */
    public function handleExceptions(RequestException $e)
    {
        $message = '';
        if ($e->getResponse()) {
            $message = $e->getResponse()
                         ->getBody()
                         ->getContents();
        }
        throw new ServerPilotException($message);
    }

    protected function mapToArrayOfEntities($apiResult, $entityClass)
    {
        return collect($apiResult['data'])
            ->map(function ($result) use($entityClass){
                return new $entityClass($result);
            })
            ->toArray();
    }

    protected function mapToEntity($apiResult, $entityClass)
    {
        $actionId = isset( $apiResult['actionid'] ) ? $apiResult['actionid'] : null;

        return new $entityClass($apiResult['data'], $actionId);
    }
}