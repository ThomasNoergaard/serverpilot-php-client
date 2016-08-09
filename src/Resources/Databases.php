<?php
namespace Noergaard\ServerPilot\Resources;

use Noergaard\ServerPilot\Contracts\DatabaseContract;

class Databases extends AbstractResource implements DatabaseContract
{

    /**
     * List All Databases
     *
     * @return array
     */
    public function all()
    {
        // TODO: Implement all() method.
    }

    /**
     * Retrieve an Existing Database
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
     * Create a Database
     *
     * @param $appId
     * @param $databaseName
     * @param $username
     * @param $password
     *
     * @return array
     */
    public function create($appId, $databaseName, $username, $password)
    {
        // TODO: Implement create() method.
    }

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
    public function update($id, $username, $password, $databaseName)
    {
        // TODO: Implement update() method.
    }

    /**
     * Delete a Database
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