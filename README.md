# ServerPilot API PHP Client

A PHP Client for ServerPilot API V1 using GuzzleHttp and PSR-4 autoloading support.

##### NOTICE This package is still under development

#### Installation
```
composer require noergaard/serverpilot
```

#### Getting Started

To get started, simply new up the Client and provide your `client_id` and `key` from ServerPilot and you're ready to go.

```php
use Noergaard\ServerPilot\Client;

$client = new Client('your_serverpilot_client_id', 'your_serverpilot_key');

```

#### Using Resources

This client package follows the same naming conventions for resources, provided by ServerPilot and their API documentation. 

For furhter details about API endpoints, please visit the [ServerPilot API V1](https://github.com/ServerPilot/API) documentation.

##### Servers

To make requests to Server resources, make a call to the `servers()` method on the `client` object.

From all request to Server resources either and array of `ServerEntity` or a single `ServerEntity` will be returned.

A `ServerEntity` has public camelcased properties, matching the returned values from the ServerPilot API.

###### List All Servers
```php
$servers = $client->servers()->all();

foreach($servers as $server)
{
    var_dump($server->name);
}
```

###### Connect a New Server
There are multiple steps involved in connection a server to ServerPilot

Please visit the [ServerPilot API V1](https://github.com/ServerPilot/API) documentation for further information.

Parameter | Type
------------ | -------------
Name | string

```php
$server = $client->servers()->create('name');

$apiKey = $server->apiKey;
```

###### Retrieve/Get a Server

Parameter | Type
------------ | -------------
Server Id | string

```php
$server = $client->servers()->get('serverId');
```

###### Update a Server

Parameter | Type
------------ | -------------
Server Id | string
Firewall Enabled | boolean
Auto Updateds Enabled | boolean

```php
$server = $client->servers()->update('serverId', true, false);
```

###### Delete a Server

Parameter | Type
------------ | -------------
Server Id | string

```php
$server = $client->servers()->delete('serverId');
```

##### System Users

To make requests to Server resources, make a call to the `systemUsers()` method on the `client` object.

From all request to Server resources either and array of `SystemUserEntity` or a single `SystemUserEntity` will be returned.

A `SystemUserEntity` has public camelcased properties, matching the returned values from the ServerPilot API.

###### List All System Users






