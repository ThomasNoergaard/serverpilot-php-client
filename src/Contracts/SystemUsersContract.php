<?php
namespace Noergaard\ServerPilot\Contracts;

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
     * @return array
     */
    public function get($id);

    /**
     * Create a System User
     *
     * @param $serverId
     * @param $name
     * @param $password
     *
     * @return array
     */
    public function create($serverId, $name, $password);

    /**
     * Update a System User
     *
     * @param $id
     * @param $password
     *
     * @return array
     */
    public function update($id, $password);

    /**
     * Delete a System User
     * Deleting a System User will delete all Apps (and Databases) associated
     *
     * @param $id
     *
     * @return array
     */
    public function delete($id);

}