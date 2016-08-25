<?php
namespace Noergaard\ServerPilot\Entities;

abstract class AbstractEntity
{

    /**
     * @var string
     */
    public $actionId;

    public function __construct(array $data, $actionId = null)
    {
        if ($actionId !== null) {
            $data['actionId'] = $actionId;
        }
        $this->buildProperties($data);
    }

    public function buildProperties(array $data)
    {
        collect($data)->each(function ($value, $property) {
            $property = (array_key_exists($property, $this->mapPropertyNames())) ? $this->mapPropertyNames()[$property] : $property;
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        });
    }

    public function getActionId()
    {
        return $this->actionId;
    }

    /**
     * @return array
     */
    abstract protected function mapPropertyNames();
}
