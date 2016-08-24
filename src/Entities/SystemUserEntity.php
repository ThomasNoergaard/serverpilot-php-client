<?php
namespace Noergaard\ServerPilot\Entities;

class SystemUserEntity extends AbstractEntity
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
    public $serverId;

    /**
     * @return array
     */
    protected function mapPropertyNames()
    {
        return [
            'serverid' => 'serverId'
        ];
    }
}