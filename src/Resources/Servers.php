<?php
namespace Noergaard\ServerPilot\Resources;

use Noergaard\ServerPilot\Contracts\ServersContract;
use Noergaard\ServerPilot\Entities\ServerEntity;

class Servers extends AbstractResource implements ServersContract
{

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->mapToArrayOfEntities($this->getRequest('/servers'), ServerEntity::class);
    }

    /**
     *{@inheritdoc}
     */
    public function get($id)
    {
        return $this->mapToEntity($this->getRequest(sprintf('/servers/%s', $id)), ServerEntity::class);
    }

    /**
     * {@inheritdoc}
     */
    public function create($name)
    {
        return $this->mapToEntity($this->postRequest('/servers', [
            'name' => $this->formatStringToLowercaseAndDashes($name)
        ]), ServerEntity::class);
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, $firewallEnabled = true, $autoUpdatesEnabled = true)
    {
        return $this->mapToEntity($this->postRequest(sprintf('/servers/%s', $id), [
            'firewall' => $firewallEnabled,
            'autoupdates' => $autoUpdatesEnabled
        ]), ServerEntity::class);
    }

    /**
     *{@inheritdoc}
     */
    public function delete($id)
    {
        return $this->mapToEntity($this->deleteRequest(sprintf('/servers/%s', $id)), ServerEntity::class);
    }
}