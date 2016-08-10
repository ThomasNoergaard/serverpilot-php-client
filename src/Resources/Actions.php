<?php
namespace Noergaard\ServerPilot\Resources;

use Noergaard\ServerPilot\Contracts\ActionsContract;

class Actions extends AbstractResource implements ActionsContract
{

    /**
     * Check the Status of an Action
     *
     * @param $id
     *
     * @return array
     */
    public function status($id)
    {
        return $this->getRequest(sprintf('/actions/%s', $id));
    }
}