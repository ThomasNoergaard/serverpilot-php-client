<?php
namespace Noergaard\ServerPilot\Resources;

use Noergaard\ServerPilot\Contracts\ServersContract;

class Servers extends AbstractResource  implements ServersContract
{

    /**
     * List all servers
     *
     * @return array
     */
    public function all()
    {
        return $this->getRequest('/servers');
    }

    /**
     * Retrieve an Existing Server
     *
     * @param $id
     *
     * @return array
     */
    public function get($id)
    {
        return $this->getRequest(sprintf('/servers/%s', $id));
    }

    /**
     * Connect a New Server
     * Use this method to tell ServerPilot that you plan to connect a new serve
     *
     * @param $name
     *
     * @return array
     */
    public function create($name)
    {
        return $this->postRequest('/servers', [
            'name' => $this->formatStringToLowercaseAndDashes($name)
        ]);
    }

    /**
     * Update a Server
     *
     * @param $id
     * @param bool $firewallEnabled
     * @param bool $autoUpdatesEnabled
     *
     * @return array
     */
    public function update($id, $firewallEnabled = true, $autoUpdatesEnabled = true)
    {
        return $this->postRequest(sprintf('/servers/%s', $id), [
            'firewall' => $firewallEnabled,
            'autoupdates' => $autoUpdatesEnabled
        ]);
    }

    /**
     * Delete a Server
     *
     * @param $id
     *
     * @return array
     */
    public function delete($id)
    {
        return $this->deleteRequest(sprintf('/servers/%s', $id));
    }
}