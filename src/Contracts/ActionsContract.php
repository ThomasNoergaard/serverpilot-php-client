<?php
namespace Noergaard\ServerPilot\Contracts;

interface ActionsContract
{

    /**
     * Check the Status of an Action
     *
     * @param $id
     *
     * @return array
     */
    public function status($id);
}