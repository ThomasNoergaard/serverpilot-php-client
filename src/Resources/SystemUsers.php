<?php
namespace Noergaard\ServerPilot\Resources;

use Noergaard\ServerPilot\Contracts\SystemUsersContract;

class SystemUsers extends AbstractResource implements SystemUsersContract
{

    /**
     * List All System Users
     *
     * @return array
     */
    public function all()
    {
        // TODO: Implement all() method.
    }

    /**
     * Retrieve an Existing System User
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
     * Create a System User
     *
     * @param $serverId
     * @param $name
     * @param $password
     *
     * @return array
     */
    public function create($serverId, $name, $password)
    {
        // TODO: Implement create() method.
    }

    /**
     * Update a System User
     *
     * @param $id
     * @param $password
     *
     * @return array
     */
    public function update($id, $password)
    {
        // TODO: Implement update() method.
    }

    /**
     * Delete a System User
     * Deleting a System User will delete all Apps (and Databases) associated
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