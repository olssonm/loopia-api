# Loopia API

A super simple wrapper for the [Loopia XML RPC-API](https://www.loopia.se/api/) for PHP.

Relies on [lstrojny/fxmlrpc](https://github.com/lstrojny/fxmlrpc) to make fast and efficient calls to the API. Requires PHP ^7.0 (PHP 7.1 is recommended for better performance).

## Installation

``` bash
$ composer require olssonm/loopia-api
```

## Usage

Using the package is straight forward – just include the client, create an instance and make your calls.

All methods are listed over at the [Loopia API-documentation](https://www.loopia.se/api/).

**Get all your domains**

``` php
    use Olssonm\LoopiaApi\Client;

    $response = (new Client('username', 'password'))
        ->getDomains()
        ->getResponse();
```

If needed, you may of course separate your code, like so:

``` php
    use Olssonm\LoopiaApi\Client;

    $client = new Client('username', 'password');
    $client->getDomains();
    $response = $client->getResponse();
```

**Check the zone records for a domain (with subdomain)**

``` php
    use Olssonm\LoopiaApi\Client;

    $response = (new Client('username', 'password'))
        ->getZoneRecords('example.com', '@')
        ->getResponse();
```

**Update your DNS (name)-servers**

``` php
    use Olssonm\LoopiaApi\Client;

    $response = (new Client('username', 'password'))
        ->updateDNSServers('example.com', ['ns1.loopia.se', 'ns2.loopia.se'])
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

## Testing

Use your username, password a domain and subdomain as arguments when running tests. For example:

```bash
vendor/bin/phpunit ./tests/LoopiaApiTests username password example.com www
```

Of course the domain under testing needs to be owned by your Loopia account. **Note:** The last test (`test_update_name_servers`) actually modifies your name servers, use with caution.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

© 2018 [Marcus Olsson](https://marcusolsson.me).
