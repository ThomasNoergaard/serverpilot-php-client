<?php
namespace Noergaard\ServerPilot\Contracts;

use Noergaard\ServerPilot\Entities\AbstractEntity;
use Noergaard\ServerPilot\Entities\ActionEntity;

interface ActionsContract
{

    /**
     * Check the Status of an Action
     *
     * @param string|AbstractEntity $id
     *
     * @return ActionEntity
     */
    public function status($id);
}