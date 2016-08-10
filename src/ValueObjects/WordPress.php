<?php
namespace Noergaard\ServerPilot\ValueObjects;

class WordPress
{

    public $site_title;
    public $admin_user;
    public $admin_password;
    public $admin_email;

    public function __construct($site_title, $admin_user, $admin_password, $admin_email)
    {
        $this->site_title = $site_title;
        $this->admin_user = $admin_user;
        $this->admin_password = $admin_password;
        $this->admin_email = $admin_email;
    }
}