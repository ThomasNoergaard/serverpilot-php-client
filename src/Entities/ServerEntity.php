<?php
namespace Noergaard\ServerPilot\Entities;

class ServerEntity extends AbstractEntity
{

    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $name;
    /**
     * @var bool
     */
    public $autoUpdates;
    /**
     * @var bool
     */
    public $firewall;
    /**
     * @var string
     */
    public $lastAddress;
    /**
     * @var string
     */
    public $lastConnection;
    /**
     * @var int
     */
    public $dateCreated;

    public $apiKey;


    /**
     * @return array
     */
    protected function mapPropertyNames()
    {
        return [
            'autoupdates' => 'autoUpdates',
            'lastaddress' => 'lastAddress',
            'lastconn' => 'lastConnection',
            'datecreated' => 'dateCreated',
            'apikey' => 'apiKey'
        ];
    }
}