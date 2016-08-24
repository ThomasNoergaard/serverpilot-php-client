<?php
namespace Noergaard\ServerPilot\Entities;

class SslEntity
{
    public $key;
    public $certificate;
    public $caCertificate;
    public $autoSsl;
    public $forceSsl;

    public function __construct(array $data)
    {
        $this->key = $data['key'];
        $this->certificate = $data['cert'];
        $this->caCertificate = $data['cacerts'];
        $this->autoSsl = $data['auto'];
        $this->forceSsl = $data['force'];
    }
}