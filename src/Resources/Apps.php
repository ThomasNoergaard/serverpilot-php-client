<?php
namespace Noergaard\ServerPilot\Resources;

use Noergaard\ServerPilot\Contracts\AppsContract;

class Apps extends AbstractResource implements AppsContract
{

    /**
     * List All Apps
     *
     * @return array
     */
    public function all()
    {
        // TODO: Implement all() method.
    }

    /**
     * Retrieve an Existing App
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
     * Create an App
     *
     * @param $systemUserId
     * @param string $runtime
     * @param array $domains
     * @param array|null $wordpress
     *
     * @return array
     */
    public function create($systemUserId, $runtime = 'php7.0', array $domains, array $wordpress = null)
    {
        // TODO: Implement create() method.
    }

    /**
     * Update an App
     *
     * @param $runtime
     * @param array $domains
     *
     * @return array
     */
    public function update($runtime, array $domains)
    {
        // TODO: Implement update() method.
    }

    /**
     * Delete an App
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