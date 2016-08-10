<?php
use Noergaard\ServerPilot\Factories\WordPressFactory;
use Noergaard\ServerPilot\ValueObjects\WordPress;

class WordPressFactoryTest extends PHPUnit_Framework_TestCase
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
    public function it_instantiates_wordpress_value_object()
    {
        $siteTitle = 'Testing';
        $adminUser = 'test_admin';
        $adminPassword = 'thisShouldBeOverEightCharactersLong';
        $adminEmail = 'john@example.com';
        $wordpress = WordPressFactory::make($siteTitle, $adminUser, $adminPassword, $adminEmail);

        $this->assertInstanceOf(WordPress::class, $wordpress);
    }

    /**
    *@test
     * @expectedException Noergaard\ServerPilot\Exceptions\WordPressPasswordNotAcceptableLengthException
    */
    public function it_throws_exception_if_password_is_not_at_least_8_characters_long()
    {
        $siteTitle = 'Testing';
        $adminUser = 'test_admin';
        $adminPassword = 'foo';
        $adminEmail = 'john@example.com';
        $wordpress = WordPressFactory::make($siteTitle, $adminUser, $adminPassword, $adminEmail);
    }

    /**
     * @test
     * @expectedException Noergaard\ServerPilot\Exceptions\WordPressEmailNotValid
     */
    public function it_throws_exception_if_email_is_not_a_valid_email()
    {
        $siteTitle = 'Testing';
        $adminUser = 'test_admin';
        $adminPassword = 'thisShouldBeOverEightCharactersLong';
        $adminEmail = 'example.com';
        $wordpress = WordPressFactory::make($siteTitle, $adminUser, $adminPassword, $adminEmail);
    }

}