<?php
namespace Noergaard\ServerPilot\Entities;

class AppEntity
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
     * @var string
     */
    public $serverId;
    /**
     * @var string
     */
    public $runtime;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->systemUserId = $data['sysuserid'];
        $this->domains = $data['domains'];
        $this->ssl = ($data['ssl'] != null) ?  new SslEntity($data['ssl']) : null;
        $this->serverId = $data['serverid'];
        $this->runtime = $data['runtime'];
    }
}