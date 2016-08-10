<?php
namespace Noergaard\ServerPilot\Factories;

use Noergaard\ServerPilot\Exceptions\DatabaseUserNameTooLongException;
use Noergaard\ServerPilot\Exceptions\DatabaseUserPasswordNotAcceptableLengthException;
use Noergaard\ServerPilot\ValueObjects\DatabaseUser;

class DatabaseUserFactory
{

    private $username;
    private $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;

        $this->validateUsername();
        $this->validatePassword();
    }

    public function makeDatabaseUserInstance()
    {
        return new DatabaseUser($this->username, $this->password);
    }

    public static function make($username, $password    )
    {
        return (new static($username,$password))->makeDatabaseUserInstance();
    }

    private function validateUsername()
    {
        if(strlen($this->username) > 16)
        {
            throw new DatabaseUserNameTooLongException("Database username length must be at most 16 characters");
        }
    }

    private function validatePassword()
    {
        if(strlen($this->password) < 8)
        {
            throw new DatabaseUserPasswordNotAcceptableLengthException('Database password length must be at least 8 characters');
        }
    }
}