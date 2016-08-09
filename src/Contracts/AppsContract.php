<?php
namespace Noergaard\ServerPilot\Contracts;

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
     * @return array
     */
    public function get($id);

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
    public function create($systemUserId, $runtime = 'php7.0', array $domains, array $wordpress = null);

    /**
     * Update an App
     *
     * @param $runtime
     * @param array $domains
     *
     * @return array
     */
    public function update($runtime, array $domains);

    /**
     * Delete an App
     *
     * @param $id
     *
     * @return array
     */
    public function delete($id);
}