<?php
namespace Noergaard\ServerPilot\Contracts;

interface DatabaseContract
{

    /**
     * List All Databases
     *
     * @return array
     */
    public function all();

    /**
     * Retrieve an Existing Database
     *
     * @param $id
     *
     * @return array
     */
    public function get($id);

    /**
     * Create a Database
     *
     * @param $appId
     * @param $databaseName
     * @param $username
     * @param $password
     *
     * @return array
     */
    public function create($appId, $databaseName, $username, $password);

    /**
     * Update the Database User Password
     *
     * @param $id
     * @param $username
     * @param $password
     * @param $databaseName
     *
     * @return array
     */
    public function update($id, $username, $password, $databaseName);

    /**
     * Delete a Database
     *
     * @param $id
     *
     * @return array
     */
    public function delete($id);
}