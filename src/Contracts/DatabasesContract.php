<?php
namespace Noergaard\ServerPilot\Contracts;

use Noergaard\ServerPilot\Entities\DatabaseEntity;
use Noergaard\ServerPilot\ValueObjects\DatabaseUser;

interface DatabasesContract
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
     * @return DatabaseEntity
     */
    public function get($id);

    /**
     * Create a Database
     *
     * @param $appId
     * @param $databaseName
     * @param DatabaseUser $databaseUser
     *
     * @return DatabaseEntity
     */
    public function create($appId, $databaseName, DatabaseUser $databaseUser);

    /**
     * Update the Database User Password
     *
     * @param $databaseId
     * @param $databaseUserId
     * @param $newPassword
     *
     * @return DatabaseEntity
     */
    public function updatePassword($databaseId, $databaseUserId, $newPassword);

    /**
     * Delete a Database
     *
     * @param $id
     *
     * @return DatabaseEntity
     */
    public function delete($id);
}