# NetBox Laravel [![Latest Stable Version](https://poser.pugx.org/cmdrsharp/netbox-laravel/v/stable)](https://packagist.org/packages/cmdrsharp/netbox-laravel) [![StyleCI](https://github.styleci.io/repos/360124398/shield?branch=main)](https://github.styleci.io/repos/360124398?branch=main) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/CmdrSharp/netbox-laravel/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/CmdrSharp/netbox-laravel/?branch=main) [![Apache licensed](https://img.shields.io/badge/license-Apache-blue.svg)](./LICENSE)

This repo contains a client for interacting with the NetBox API - more specifically to be able to treat them more like resources (akin to Laravel models).

Each resource type defines a `fillable` property which allows mass assignment. Each property is named 1:1 with the NetBox API documentation.
Resources also contain helper methods to allow easy lookups.

# Current Requirements
* PHP 7.4 or newer
* Laravel [7.0](https://laravel.com/docs/7.0) or newer
* NetBox (2.10 tested)

# Installation
Via composer
```bash
$ composer require cmdrsharp/netbox-laravel
```

After installation, publish the configuration file.

```
php artisan vendor:publish --provider="CmdrSharp\NetBox\NetBoxServiceProvider"
```

Which will create a `netbox.php` file in your Laravel config directory which contains keys for the NetBox URL and API Token.
It is recommended to simply define these in your `.env` file. The config file will automatically read from these values.
```
NETBOX_URL=
NETBOX_API_TOKEN=5672
```

If you for some reason which to disable SSL Validation toward the NetBox API, you can override validation in the `.env` file.
```
NETBOX_VERIFY_SSL=false
```

# Usage
For creating a new resource, instantiate the correct model and call its create method.
```php
use CmdrSharp\NetBox\Ipam\Prefix;

$prefix = new Prefix([
    'prefix' => '172.16.0.0/24', // Prefixes are specified according to the NetBox API Docs
    'role' => 1, // This is an ID referring to the resource in NetBox
    'site' => 1, // This is an ID referring to the resource in NetBox
    'tenant' => 1, // This is an ID referring to the resource in NetBox
    'vlan' => 1, // This is an ID referring to the resource in NetBox
    'is_pool' => false,
    'description' => 'Cool Network',
    'vrf' => 1, // This is an ID referring to the resource in NetBox
    'status' => 'active'
]);

$prefix->create();
// Returns a Guzzle ResponseInterface with getBody and getStatusCode methods.
```

For your convenience, each resource also contains named set-methods that cover all fillable properties.
````php
use CmdrSharp\NetBox\Ipam\Prefix;

$prefix = new Prefix();
$prefix->setPrefix('172.16.0.0/24')
        ->setRole(1)
        ->setSite(1)
        ->setTenant(1)
        ->setVlan(1)
        ->setPool(false)
        ->setDescription('Cool Network')
        ->setVrf(1)
        ->setStatus('active')
        ->create();
````

### Example: Get a prefix from the NetBox API
```php
use CmdrSharp\NetBox\Ipam\Prefix;

Prefix::wherePrefix('172.16.0.0/24');
// Returns a Guzzle ResponseInterface with getBody and getStatusCode methods.
```

# Other resources
* [Laravel NetBox BGP](https://github.com/CmdrSharp/netbox-laravel-bgp) - Extension that includes BGP Resources

# Developing
When creating new resources, please ensure to follow existing standards to ensure they remain compatible.
The fillable array should ideally map 1:1 with the NetBox API Documentation. In cases where this requires special attribute management, we rely on the user knowing this ahead of time for mass assignment, and offer helpers in fluid setters to deal with these scenarios.

Currently, no validation of input should be performed. This is subject to change as we may opt to validate attributes according to NetBox API specs.

### Testing
All resources should be covered by tests.
Tests should extend the NetBoxTestCase class, which defines config values such as the URL to the NetBox Instance (which can easily be spun up via Docker) and a random API Key which should be created in said NetBox instance.

# Versioning
This package follows [Explicit Versioning](https://github.com/exadra37-versioning/explicit-versioning).
