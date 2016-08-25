<?php
namespace Noergaard\ServerPilot\Entities;

class SslEntity extends AbstractEntity
{
    public $key;
    public $certificate;
    public $caCertificate;
    public $autoSsl;
    public $forceSsl;

    /**
     * @return array
     */
    protected function mapPropertyNames()
    {
        return [
            'cert' => 'certificate',
            'cacerts' => 'caCertificate',
            'autossl' => 'autoSsl',
            'forcessl' => 'forceSsl'
        ];
    }
}
