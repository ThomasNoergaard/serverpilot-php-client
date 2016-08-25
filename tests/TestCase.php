<?php

class TestCase extends PHPUnit_Framework_TestCase
{

    protected $clientId;
    protected $key;

    public function setUp()
    {
        parent::setUp();

        $this->clientId = 'your_client_id';
        $this->key = 'your_key';
    }
}