<?php
namespace Noergaard\ServerPilot\Resources;

use Noergaard\ServerPilot\Contracts\AppsContract;
use Noergaard\ServerPilot\Entities\AppEntity;
use Noergaard\ServerPilot\ValueObjects\WordPress;

class Apps extends AbstractResource implements AppsContract
{

    const PHP71 = 'php7.1';
    const PHP70 = 'php7.0';
    const PHP56 = 'php5.6';
    const PHP55 = 'php5.5';
    const PHP54 = 'php5.4';
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        $apiResult = $this->getRequest('/apps');
        return $this->mapToArrayOfEntities($apiResult, AppEntity::class);
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        return $this->mapToEntity($this->getRequest(sprintf('/apps/%s',$id)), AppEntity::class);
    }

    /**
     * {@inheritdoc}
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

        return $this->mapToEntity($this->postRequest('/apps', $data), AppEntity::class);
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, $runtime, array $domains)
    {
        return $this->mapToEntity($this->postRequest(sprintf('/apps/%s', $id), [
            'runtime' => $runtime,
            'domains' => $domains
        ]), AppEntity::class);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        return $this->mapToEntity($this->deleteRequest(sprintf('/apps/%s', $id)), AppEntity::class);
    }

}