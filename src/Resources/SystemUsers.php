<?php
namespace Noergaard\ServerPilot\Resources;

use Noergaard\ServerPilot\Contracts\SystemUsersContract;
use Noergaard\ServerPilot\Entities\SystemUserEntity;

class SystemUsers extends AbstractResource implements SystemUsersContract
{

    /**
     *{@inheritdoc}
     */
    public function all()
    {
        return $this->mapToArrayOfEntities($this->getRequest('/sysusers'), SystemUserEntity::class);
    }

    /**
     *{@inheritdoc}
     */
    public function get($id)
    {
        return $this->mapToEntity($this->getRequest(sprintf('/sysusers/%s', $id)), SystemUserEntity::class);
    }

    /**
     *{@inheritdoc}
     */
    public function create($serverId, $name, $password)
    {
        return $this->mapToEntity($this->postRequest('/sysusers', [
            'serverid' => $serverId,
            'name' => $this->formatStringToLowercaseAndDashes($name),
            'password' => $password
        ]), SystemUserEntity::class);
    }

    /**
     *{@inheritdoc}
     */
    public function update($id, $password)
    {
        return $this->mapToEntity($this->postRequest(sprintf('/sysusers/%s', $id), [
           'password' => $password
        ]), SystemUserEntity::class);
    }

    /**
     *{@inheritdoc}
     */
    public function delete($id)
    {
        return $this->mapToEntity($this->deleteRequest(sprintf('/sysusers/%s', $id)), SystemUserEntity::class);
    }
}