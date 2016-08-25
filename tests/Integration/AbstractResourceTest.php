<?php
use Noergaard\ServerPilot\Resources\AbstractResource;

class AbstractResourceTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var AbstractResource
     */
    private $abstractResource;

    public function setUp()
    {
        parent::setUp();
        $this->abstractResource = Mockery::mock(AbstractResource::class)->makePartial();
    }
    
    public function tearDown()
    {
        parent::tearDown();
    }
    
    /**
    * @test
    */
    public function it_formats_string()
    {
        $expected = 'hello-world';

        $formattedString = $this->abstractResource->formatStringToLowercaseAndDashes('Hello WORLD');

        $this->assertEquals($expected, $formattedString);
    }
}
