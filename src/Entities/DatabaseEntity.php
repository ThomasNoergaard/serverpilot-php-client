<?php
namespace Noergaard\ServerPilot\Entities;

class DatabaseEntity extends AbstractEntity
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
     * @var string
     */
    public $appId;

    /**
     * @var string
     */
    public $serverId;

    /**
     * @var array
     */
    public $user;

    /**
     * @return array
     */
    protected function mapPropertyNames()
    {
        return [
          'appid' => 'appId',
          'serverid' => 'serverId'
        ];
    }
}