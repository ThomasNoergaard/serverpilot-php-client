# ServerPilot API PHP Client

A PHP Client for ServerPilot API V1 using GuzzleHttp and PSR-4 autoloading support.

### NOTICE This package is still under development

## Installation
```
composer require noergaard/serverpilot
```

## Getting Started

To get started, simply new up the Client and provide your `client_id` and `key` from ServerPilot and you're ready to go.

```php
use Noergaard\ServerPilot\Client;

$client = new Client('your_serverpilot_client_id', 'your_serverpilot_key');

```

## Using Resources

This client package follows the same naming conventions for resources, provided by ServerPilot and their API documentation. 

For further details about API endpoints, please visit the [ServerPilot API V1](https://github.com/ServerPilot/API) documentation.

### Servers

To make requests to Server resources, make a call to the `servers()` method on the `client` object.

From all request to Server resources either and array of `ServerEntity` or a single `ServerEntity` will be returned.

A `ServerEntity` has public camelcase properties, matching the returned values from the ServerPilot API.

#### List All Servers
```php
$servers = $client->servers()->all();

foreach($servers as $server)
{
    var_dump($server->name);
}
```

#### Connect a New Server
There are multiple steps involved in connection a server to ServerPilot

Please visit the [ServerPilot API V1](https://github.com/ServerPilot/API) documentation for further information.

Parameter | Type
------------ | -------------
Name | string

```php
$server = $client->servers()->create('name');

// Api key to use for provision
$apiKey = $server->apiKey;
```

#### Retrieve/Get a Server

Parameter | Type
------------ | -------------
Server Id | string

```php
$server = $client->servers()->get('serverId');
```

#### Update a Server

Parameter | Type
------------ | -------------
Server Id | string
Firewall Enabled | boolean
Auto Updates Enabled | boolean

```php
$server = $client->servers()->update('serverId', true, false);
```

#### Delete a Server

Parameter | Type
------------ | -------------
Server Id | string

```php
$server = $client->servers()->delete('serverId');
```

### System Users

To make requests to System User resources, make a call to the `systemUsers()` method on the `client` object.

From all request to System User resources either and array of `SystemUserEntity` or a single `SystemUserEntity` will be returned.

A `SystemUserEntity` has public camelcase properties, matching the returned values from the ServerPilot API.

#### List All System Users
```php
$systemUsers = $client->systemUsers()->all()

foreach($systemUsers as $systemUser)
{
    var_dump($systemUser->name);
}
```

#### Create a System User

**Notice** User name length **must** be between 3 and 32 characters, lowercase ascii letters, digits or a dash. 

**Notice** Password length **must** be **at least** 8 characters and **no more** than 200 characters long, with no leading or trailing whitespace.

Please visit the [ServerPilot API V1](https://github.com/ServerPilot/API) documentation for further information.

Parameter | Type
------------ | -------------
Server Id | string
Username | string 
Password | string

```php
$systemUser = $client->systemUsers()->create('serverId', 'username', 'password');

$id = $systemUser->id;
```

#### Retrieve/Get a System User

Parameter | Type
------------ | -------------
System User Id | string

```php
$systemUser = $client->systemUsers()->get('systemUserId');
```

#### Update a System User
**Notice** Password length **must** be **at least** 8 characters and **no more** than 200 characters long, with no leading or trailing whitespace.

Please visit the [ServerPilot API V1](https://github.com/ServerPilot/API) documentation for further information.

Parameter | Type
------------ | -------------
System User Id | string
Password | string

```php
$systemUser = $client->systemUsers()->update('systemUserId', 'password');
```

#### Delete a System User
Parameter | Type
------------ | -------------
System User Id | string

```php
$systemUser = $client->systemUsers()->delete('systemUserId');
```

### Apps

To make requests to App resources, make a call to the `apps()` method on the `client` object.

From all request to App resources either and array of `AppEntity` or a single `AppEntity` will be returned.

A `AppEntity` has public camelcase properties, matching the returned values from the ServerPilot API.

#### List All Apps
```php
$apps = $client->apps()->all();

foreach($apps as $app
{
    var_dump($app->name);
}
```

#### Create an App

**Notice** Upon creating a new app, the Server where the App will be created, is determined by the System User.

When creating an App you have the possibility to install WordPress at the same time.

If you wish to install WordPress, you have to provide the necessary information and credentials for the
WordPress install process. 

To streamline this process, this package uses a `WordPressFactory` object, which instantiates the correct object to be passed to the ServerPilot API

If you **DO NOT** want to install WordPress, you don't have to provide any data to that parameter.

Parameter | Type
------------ | -------------
App Name | string
System User Id | string
PHP Runtime | string
Domains | array
WordPress | WordPress object *or* null 

To make the choice of PHP runtimes easier, the `Apps` class provides constants of the various runtimes supported by ServerPilot
```php
// Use PHP 5.4
$runtime = Apps::PHP54;

// Use PHP 5.5
$runtime = Apps::PHP55;

// Use PHP 5.6
$runtime = Apps::PHP56;

// Use PHP 7.0
$runtime = Apps::PHP70;

// Use PHP 7.1
$runtime = Apps::PHP71;
```


**Create an App without WordPress**
```php
$app = $client->apps()->create('appName', 'systemUserId', 'runtime', ['example.com', 'www.example.com']);
```


**Create an App with WordPress**

Wordpress Factory Parameters | Type
------------ | -------------
Site Title | string
Admin User Name | string
Admin Password | string
Admin Email| string

```php
$wordpress = WordPressFactory::make('Site Title', 'admin','password', 'john@example.com');

$app = $client->apps()->create('appName', 'systemUserId', 'runtime', ['example.com', 'www.example.com'], $wordpress);
```

#### Retrieve/Get Details of an App
Parameters | Type
------------ | -------------
App Id | string

```php
$app = $client->apps()->get('appId');
```

#### Update an App
Parameter | Type
------------ | -------------
App Id | string
PHP Runtime | string
Domains | array

To make the choice of PHP runtimes easier, the `Apps` class provides constants of the various runtimes supported by ServerPilot
```php
// Use PHP 5.4
$runtime = Apps::PHP54;

// Use PHP 5.5
$runtime = Apps::PHP55;

// Use PHP 5.6
$runtime = Apps::PHP56;

// Use PHP 7.0
$runtime = Apps::PHP70;

// Use PHP 7.1
$runtime = Apps::PHP71;
```

```php
$app = $client->apps()->update('appId', 'runtime', ['example.com', 'www.example.com']);
```

#### Delete an App
Parameters | Type
------------ | -------------
App Id | string

```php
$app = $client->apps()->delete('appId');
```

#### Custom SSL - AutoSSL - ForceSSL
These parts has not been implemented in this package yet,
but will be soon.

### Databases
To make requests to Database resources, make a call to the `databases()` method on the `client` object.

From all request to Database resources either and array of `DatabaseEntity` or a single `DatabaseEntity` will be returned.

A `DatabaseEntity` has public camelcase properties, matching the returned values from the ServerPilot API.

#### List All Databases
```php
$databases = $client->databases()->all();
```

#### Create a Database
To create a Database in an App, a Database user object is required by the ServerPilot API.
This package streamlines this process by using a `DatabaseUserFactory` object.

**Notice** Database User names **must** be **at most** 16 characters.

**Notice** Database passwords **must** be **at least** 8 and **no more** than 200 charachters long, with no leading or trailing whitespace.

**Notice** Database names  **must** be between 3 and 32 characters, lowercase ascii letters, digits or a dash. 

Parameters | Type
------------ | -------------
App Id | string
Database Name | string
Database User | DatabaseUser object

The `DatabaseUserFactory` object, takes the following parameters

Parameters | Type
------------ | -------------
User Name | string
Password | string

```php
$databaseUser = DatabaseUserFactory::make('username', 'password');

$database = $client->databases()->create('appId', 'databaseName', $databaseUser);
```

#### Retrieve/Get an existing Database

Parameters | Type
------------ | -------------
Database Id | string

```php
$database = $client->databases()->get('databaseId');
```

#### Update the Database User Password

Parameters | Type
------------ | -------------
Database Id | string
Database User Id | string
New Database Password | string

```php
$database = $client->databases()->updatePassword('databaseId', 'databaseUserId', 'password');
```

#### Delete a Database
Parameters | Type
------------ | -------------
Database Id | string

```php
$database = $client->databases()->delete('databaseId');
```

### Actions

To make requests to Action resources, make a call to the `actions()` method on the `client` object.

From all request to Action resources either and array of `ActionEntity` or a single `ActionEntity` will be returned.

A `ActionEntity` has public camelcase properties, matching the returned values from the ServerPilot API.

#### Check the Status of an Action

You can check actions of any resource that are modifying data.
 
You are modifying data when you are `creating`, `updating` or `deleting` a resource

To check an action for a resource, you can just pass the resource entity as a parameter to the `status()` method on the `action` object.

You can also just provide the `action id` if you like.

Parameters | Type
------------ | -------------
Action Id | string *or* AbstractEntity

**Checking Action when Connecting a Server and passing the ServerEntity to the Status method**
```php
$server = $client->servers()->create('name');

$action = $client->actions()->status($server);
```

**Checking Action when Connecting a Server and passing the Action Id to the Status method**
```php
$server = $client->servers()->create('name');

$action = $client->actions()->status($server->getActionId());
```

## Todo

- [x] Implement Servers
- [x] Implement System Users
- [ ] Implement Apps
- [x] Implement Databases
- [x] Implement Actions

#### Todo on Apps

- [ ] Add a Custom SSL Certificate
- [ ] Enable AutoSSL
- [ ] Delete a Custom SSL Certificate or Disable AutoSSL
- [ ] Enable or Disable ForceSSL

## Testing

There are two types of tests in this package: Unit tests and Integration tests.

#### Unit Tests
Are good to go out of the box.

To run these test you can run them by the `Unit` directory

`phpunit ./tests/Unit`


#### Integration Tests
Integration tests hits the endpoint on the ServerPilot API.

It is therefore required that your provide a ServerPilot `client_id` and `key` to run these test.

You can add these inside the `TestCase` class, which are placed under `/tests/TestCase`.

```php
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
```

