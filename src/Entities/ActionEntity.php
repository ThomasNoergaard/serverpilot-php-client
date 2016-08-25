<?php
namespace Noergaard\ServerPilot\Entities;

class ActionEntity extends AbstractEntity
{

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $serverId;

    /**
     * @var string
     */
    public $status;

    /**
     * @var int
     */
    public $dateCreated;

    public function __construct(array $data, $actionId = null)
    {
        $actionId = $data['id'];

        parent::__construct($data, $actionId);
    }

    /**
     * @return array
     */
    protected function mapPropertyNames()
    {
       return [
         'serverid' => 'serverId',
         'datecreated' => 'dateCreated'
       ];
    }
}