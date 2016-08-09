<?php
namespace Noergaard\ServerPilot\Resources;

use Noergaard\ServerPilot\Contracts\ServersContract;

class Servers extends AbstractResource  implements ServersContract
{

    /**
     * List all servers
     *
     * @return array
     */
    public function all()
    {
        // TODO: Implement all() method.
    }

    /**
     * Retrieve an Existing Server
     *
     * @param $id
     *
     * @return array
     */
    public function get($id)
    {
        // TODO: Implement get() method.
    }

    /**
     * Connect a New Server
     * Use this method to tell ServerPilot that you plan to connect a new serve
     *
     * @param $name
     *
     * @return array
     */
    public function create($name)
    {
        // TODO: Implement create() method.
    }

    /**
     * Update a Server
     *
     * @param $id
     * @param bool $firewallEnabled
     * @param bool $autoUpdatesEnabled
     *
     * @return array
     */
    public function update($id, $firewallEnabled = true, $autoUpdatesEnabled = true)
    {
        // TODO: Implement update() method.
    }

    /**
     * Delete a Server
     *
     * @param $id
     *
     * @return array
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
}