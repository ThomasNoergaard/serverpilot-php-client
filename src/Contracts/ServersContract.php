<?php
namespace Noergaard\ServerPilot\Contracts;

use Noergaard\ServerPilot\Entities\ServerEntity;

interface ServersContract
{

    /**
     * List all servers
     *
     * @return array
     */
    public function all();

    /**
     * Retrieve an Existing Server
     *
     * @param $id
     *
     * @return ServerEntity
     */
    public function get($id);

    /**
     * Connect a New Server
     * Use this method to tell ServerPilot that you plan to connect a new serve
     *
     * @param $name
     *
     * @return ServerEntity
     */
    public function create($name);

    /**
     * Update a Server
     *
     * @param $id
     * @param bool $firewallEnabled
     * @param bool $autoUpdatesEnabled
     *
     * @return ServerEntity
     */
    public function update($id, $firewallEnabled = true, $autoUpdatesEnabled = true);

    /**
     * Delete a Server
     *
     * @param $id
     *
     * @return ServerEntity
     */
    public function delete($id);
}
