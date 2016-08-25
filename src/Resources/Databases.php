<?php
namespace Noergaard\ServerPilot\Resources;

use Noergaard\ServerPilot\Contracts\DatabasesContract;
use Noergaard\ServerPilot\Entities\DatabaseEntity;
use Noergaard\ServerPilot\ValueObjects\DatabaseUser;

class Databases extends AbstractResource implements DatabasesContract
{

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->mapToArrayOfEntities($this->getRequest('/dbs'), DatabaseEntity::class);
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        return $this->mapToEntity($this->getRequest(sprintf('/dbs/%s', $id)), DatabaseEntity::class);
    }

    /**
     * {@inheritdoc}
     */
    public function create($appId, $databaseName, DatabaseUser $databaseUser)
    {
        return $this->mapToEntity($this->postRequest('/dbs', [
           'appid' => $appId,
           'name' => $this->formatStringToLowercaseAndDashes($databaseName),
           'user' => $databaseUser
        ]), DatabaseEntity::class);
    }

    /**
     * {@inheritdoc}
     */
    public function updatePassword($databaseId, $databaseUserId, $newPassword)
    {
        $user = new \stdClass;
        $user->id = $databaseUserId;
        $user->password = $newPassword;

        return $this->mapToEntity($this->postRequest(sprintf('/dbs/%s', $databaseId), [
            'user' => $user
        ]),DatabaseEntity::class);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        return $this->mapToEntity($this->deleteRequest(sprintf('/dbs/%s', $id)), DatabaseEntity::class);
    }
}