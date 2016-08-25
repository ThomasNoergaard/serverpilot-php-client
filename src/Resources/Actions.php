<?php
namespace Noergaard\ServerPilot\Resources;

use Noergaard\ServerPilot\Contracts\ActionsContract;
use Noergaard\ServerPilot\Entities\AbstractEntity;
use Noergaard\ServerPilot\Entities\ActionEntity;

class Actions extends AbstractResource implements ActionsContract
{

    /**
     * {@inheritdoc}
     */
    public function status($id)
    {
        $id = ($id instanceof AbstractEntity) ? $id->getActionId() : $id;
        return $this->mapToEntity($this->getRequest(sprintf('/actions/%s', $id)), ActionEntity::class);
    }
}