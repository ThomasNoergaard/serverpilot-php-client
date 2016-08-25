<?php
namespace Noergaard\ServerPilot\Factories;

use Noergaard\ServerPilot\Exceptions\WordPressEmailNotValid;
use Noergaard\ServerPilot\Exceptions\WordPressPasswordNotAcceptableLengthException;
use Noergaard\ServerPilot\ValueObjects\WordPress;

class WordPressFactory
{
    private $siteTitle;
    private $adminUser;
    private $adminPassword;
    private $adminEmail;

    public function __construct($siteTitle, $adminUser, $adminPassword, $adminEmail)
    {
        $this->siteTitle = $siteTitle;
        $this->adminUser = $adminUser;
        $this->adminPassword = $adminPassword;
        $this->adminEmail = $adminEmail;

        $this->validatePassword();
        $this->validateEmail();
    }

    /**
     * Validates that password is over 8 characters long
     *
     * @throws WordPressPasswordNotAcceptableLengthException
     */
    private function validatePassword()
    {
        if (strlen($this->adminPassword) < 8) {
            throw new WordPressPasswordNotAcceptableLengthException('Admin Password must be at least 8 characters long');
        }
    }

    private function validateEmail()
    {
        if (!filter_var($this->adminEmail, FILTER_VALIDATE_EMAIL)) {
            throw new WordPressEmailNotValid("Admin Email {$this->adminEmail}, is not a valid email address");
        }
    }

    /**
     * Instantiates WordPress Value Object
     *
     * @return WordPress
     */
    public function makeWordPressInstance()
    {
        return new WordPress($this->siteTitle, $this->adminUser, $this->adminPassword, $this->adminEmail);
    }

    /**
     * Make instance of WordPress Value Object
     *
     * @param $siteTitle
     * @param $adminUser
     * @param $adminPassword
     * @param $adminEmail
     *
     * @return WordPress
     */
    public static function make($siteTitle, $adminUser, $adminPassword, $adminEmail)
    {
        return (new static($siteTitle, $adminUser, $adminPassword, $adminEmail))->makeWordPressInstance();
    }
}
