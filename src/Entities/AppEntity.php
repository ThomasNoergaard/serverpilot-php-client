<?php
namespace Noergaard\ServerPilot\Entities;

class AppEntity extends AbstractEntity
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
    public $systemUserId;
    /**
     * @var array
     */
    public $domains;
    /**
     * @var SslEntity
     */
    public $ssl;

    /**
     * @var array
     */
    public $autoSsl;

    /**
     * @var string
     */
    public $serverId;
    /**
     * @var string
     */
    public $runtime;

    public function __construct(array $data, $actionId = null)
    {
        if(isset($data['ssl']))
        {
            $data['ssl'] = ($data['ssl'] == null) ? null : new SslEntity($data['ssl']);
        }

        parent::__construct($data, $actionId);
    }

    /**
     * @return array
     */
    protected function mapPropertyNames()
    {
        return [
            'sysuserid' => 'systemUserId',
            'serverid' => 'serverId',
            'autossl' => 'autoSsl'

        ];
    }
}