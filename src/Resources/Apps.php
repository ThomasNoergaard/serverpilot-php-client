<?php
namespace Noergaard\ServerPilot\Resources;

use Noergaard\ServerPilot\Contracts\AppsContract;
use Noergaard\ServerPilot\ValueObjects\WordPress;

class Apps extends AbstractResource implements AppsContract
{

    const PHP71 = 'php7.1';
    const PHP70 = 'php7.0';
    const PHP56 = 'php5.6';
    const PHP55 = 'php5.5';
    const PHP54 = 'php5.4';
    /**
     * List All Apps
     *
     * @return array
     */
    public function all()
    {
        return $this->getRequest('/apps');
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
        return $this->getRequest(sprintf('/apps/%s',$id));
    }

    /**
     * Create an App
     *
     * @param $name
     * @param $systemUserId
     * @param string $runtime
     * @param array $domains
     * @param WordPress|null $wordPress
     *
     * @return array
     */
    public function create($name, $systemUserId, $runtime = 'php7.0', array $domains, WordPress $wordPress = null)
    {
        $data = [
            'name' => $name,
            'sysuserid' => $systemUserId,
            'runtime' => $runtime,
            'domains' => $domains,

        ];

        if($wordPress !== null)
        {
            $data['wordpress'] = $wordPress;
        }

        return $this->postRequest('/apps', $data);
    }

    /**
     * Update an App
     *
     * @param $id
     * @param $runtime
     * @param array $domains
     *
     * @return array
     */
    public function update($id, $runtime, array $domains)
    {
        return $this->postRequest(sprintf('/apps/%s', $id), [
            'runtime' => $runtime,
            'domains' => $domains
        ]);
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
        return $this->deleteRequest(sprintf('/apps/%s', $id));
    }
}