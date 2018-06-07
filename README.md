# Loopia API

A super simple wrapper for the [Loopia XML RPC-API](https://www.loopia.se/api/) for PHP.

Relies on [lstrojny/fxmlrpc](https://github.com/lstrojny/fxmlrpc) to make fast and efficient calls to the API. Requires PHP ^7.0.

### Installation

``` bash
$ composer require olssonm/loopia-api
```

### Usage

Using the package is straight forward – just include the client, create an instance and make your calls.

All methods are listed over at the [Loopia API-documentation](https://www.loopia.se/api/).

**Get all your domains**

``` php
    use Olssonm\LoopiaApi\Client;

    $response = (new Client('username', 'password'))
        ->getDomains()
        ->getResponse();
```

**Check the zone records for a domain (with subdomain)**

``` php
    use Olssonm\LoopiaApi\Client;

    $response = (new Client('username', 'password'))
        ->getZoneRecords('example.com', '@')
        ->getResponse();
```

**Update your zone records**

``` php
    use Olssonm\LoopiaApi\Client;

    $response = (new Client('username', 'password'))
        ->updateZoneRecord('example.com', '@', [
            'type' => 'A',
            'ttl' => '3600',
            'priority' => 10,
            'rdata' => '74.125.0.0',
            'record_id' => 0
        ])
        ->getResponse();
```

### Testing

Use your username, password a domain and subdomain as arguments when running tests. For example:

```bash
vendor/bin/phpunit ./tests/LoopiaApiTests username password example.com www
```
