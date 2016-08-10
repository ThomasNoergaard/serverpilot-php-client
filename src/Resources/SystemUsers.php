<?php
namespace Noergaard\ServerPilot\Resources;

use Noergaard\ServerPilot\Contracts\SystemUsersContract;

class SystemUsers extends AbstractResource implements SystemUsersContract
{

    /**
     * List All System Users
     *
     * @return array
     */
    public function all()
    {
        return $this->getRequest('/sysusers');
    }

    /**
     * Retrieve an Existing System User
     *
     * @param $id
     *
     * @return array
     */
    public function get($id)
    {
        return $this->getRequest(sprintf('/sysusers/%s', $id));
    }

    /**
     * Create a System User
     *
     * @param $serverId
     * @param $name
     * @param $password
     *
     * @return array
     */
    public function create($serverId, $name, $password)
    {
        return $this->postRequest('/sysusers', [
            'serverid' => $serverId,
            'name' => $this->formatStringToLowercaseAndDashes($name),
            'password' => $password
        ]);
    }

    /**
     * Update a System User
     *
     * @param $id
     * @param $password
     *
     * @return array
     */
    public function update($id, $password)
    {
        return $this->postRequest(sprintf('/sysusers/%s', $id), [
           'password' => $password
        ]);
    }

    /**
     * Delete a System User
     * Deleting a System User will delete all Apps (and Databases) associated
     *
     * @param $id
     *
     * @return array
     */
    public function delete($id)
    {
        return $this->deleteRequest(sprintf('/sysusers/%s', $id));
    }
}