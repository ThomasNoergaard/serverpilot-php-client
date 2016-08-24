<?php
namespace Noergaard\ServerPilot\Contracts;

use Noergaard\ServerPilot\Entities\SystemUserEntity;

interface SystemUsersContract
{

    /**
     * List All System Users
     *
     * @return array
     */
    public function all();

    /**
     * Retrieve an Existing System User
     *
     * @param $id
     *
     * @return SystemUserEntity
     */
    public function get($id);

    /**
     * Create a System User
     *
     * @param $serverId
     * @param $name
     * @param $password
     *
     * @return SystemUserEntity
     */
    public function create($serverId, $name, $password);

    /**
     * Update a System User
     *
     * @param $id
     * @param $password
     *
     * @return SystemUserEntity
     */
    public function update($id, $password);

    /**
     * Delete a System User
     * Deleting a System User will delete all Apps (and Databases) associated
     *
     * @param $id
     *
     * @return SystemUserEntity
     */
    public function delete($id);

}