<?php
namespace Noergaard\ServerPilot\Contracts;

use Noergaard\ServerPilot\Entities\AppEntity;
use Noergaard\ServerPilot\ValueObjects\WordPress;

interface AppsContract
{

    /**
     * List All Apps
     *
     * @return array
     */
    public function all();

    /**
     * Retrieve an Existing App
     *
     * @param $id
     *
     * @return AppEntity
     */
    public function get($id);

    /**
     * Create an App
     *
     * @param $name
     * @param $systemUserId
     * @param string $runtime
     * @param array $domains
     * @param WordPress|null $wordPress
     *
     * @return AppEntity
     */
    public function create($name, $systemUserId, $runtime = 'php7.0', array $domains, WordPress $wordPress = null);

    /**
     * Update an App
     *
     * @param $id
     * @param $runtime
     * @param array $domains
     *
     * @return AppEntity
     */
    public function update($id, $runtime, array $domains);

    /**
     * Delete an App
     *
     * @param $id
     *
     * @return AppEntity
     */
    public function delete($id);
}