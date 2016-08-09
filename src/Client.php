<?php
namespace Noergaard\ServerPilot;

use Noergaard\ServerPilot\Contracts\ActionsContract;
use Noergaard\ServerPilot\Contracts\AppsContract;
use Noergaard\ServerPilot\Contracts\DatabaseContract;
use Noergaard\ServerPilot\Contracts\ServersContract;
use Noergaard\ServerPilot\Contracts\SystemUsersContract;
use Noergaard\ServerPilot\Factories\GuzzleFactory;
use Noergaard\ServerPilot\Resources\Actions;
use Noergaard\ServerPilot\Resources\Apps;
use Noergaard\ServerPilot\Resources\Databases;
use Noergaard\ServerPilot\Resources\Servers;
use Noergaard\ServerPilot\Resources\SystemUsers;

class Client
{

    protected $clientId;
    protected $key;
    protected $guzzleClient;

    public function __construct($clientId, $key)
    {
        $this->clientId = $clientId;
        $this->key = $key;
        $this->guzzleClient = GuzzleFactory::make($clientId, $key);
    }

    /**
     * Call Servers methods
     *
     * @return ServersContract
     */
    public function servers()
    {
        return new Servers($this->guzzleClient);
    }

    /**
     * Call System users methods
     *
     * @return SystemUsersContract
     */
    public function systemUsers()
    {
        return new SystemUsers($this->guzzleClient);
    }

    /**
     * Call Apps methods
     *
     * @return AppsContract
     */
    public function apps()
    {
        return new Apps($this->guzzleClient);
    }

    /**
     * Call Databases methods
     *
     * @return DatabaseContract
     */
    public function databases()
    {
        return new Databases($this->guzzleClient);
    }

    /**
     * Call Actions methods
     *
     * @return ActionsContract
     */
    public function actions()
    {
        return new Actions($this->guzzleClient);
    }
}