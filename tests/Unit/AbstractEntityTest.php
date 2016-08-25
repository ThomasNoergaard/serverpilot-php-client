<?php
use Illuminate\Support\Collection;
use Noergaard\ServerPilot\Entities\AbstractEntity;

class AbstractEntityTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    
    public function tearDown()
    {
        parent::tearDown();
    }
    
    /**
    * @test
    */
    public function it_builds_properties_with_correct_camel_casing()
    {
        $stub = new EntityStub([
            'correctcamelcasing' => 'testing string that should be assigned'
        ]);

        $this->assertEquals('testing string that should be assigned', $stub->correctCamelCasing);
    }
}

class EntityStub extends AbstractEntity
{
    public $correctCamelCasing;

    /**
     * @return array
     */
    protected function mapPropertyNames()
    {
        return [
            'correctcamelcasing' => 'correctCamelCasing',
        ];
    }
}
