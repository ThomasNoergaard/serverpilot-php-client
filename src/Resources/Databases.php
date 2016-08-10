<?php
namespace Noergaard\ServerPilot\Resources;

use Noergaard\ServerPilot\Contracts\DatabasesContract;
use Noergaard\ServerPilot\ValueObjects\DatabaseUser;

class Databases extends AbstractResource implements DatabasesContract
{

    /**
     * List All Databases
     *
     * @return array
     */
    public function all()
    {
        return $this->getRequest('/dbs');
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
        return $this->getRequest(sprintf('/dbs/%s', $id));
    }

    /**
     * Create a Database
     *
     * @param $appId
     * @param $databaseName
     * @param DatabaseUser $databaseUser
     *
     * @return array
     */
    public function create($appId, $databaseName, DatabaseUser $databaseUser)
    {
        return $this->postRequest('/dbs', [
           'appid' => $appId,
           'name' => $this->formatStringToLowercaseAndDashes($databaseName),
           'user' => $databaseUser
        ]);
    }

    /**
     * Update the Database User Password
     *
     * @param $databaseId
     * @param $databaseUserId
     * @param $newPassword
     *
     * @return array
     */
    public function updatePassword($databaseId, $databaseUserId, $newPassword)
    {
        $user = new \stdClass;
        $user->id = $databaseUserId;
        $user->password = $newPassword;

        return $this->postRequest(sprintf('/dbs/%s', $databaseId), [
            'user' => $user
        ]);
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
        return $this->deleteRequest(sprintf('/dbs/%s', $id));
    }
}