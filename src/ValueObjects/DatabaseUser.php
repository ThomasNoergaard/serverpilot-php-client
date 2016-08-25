<?php
namespace Noergaard\ServerPilot\ValueObjects;

class DatabaseUser
{
    public $name;
    public $password;

    public function __construct($name, $password)
    {
        $this->name = $name;
        $this->password = $password;
    }
}
