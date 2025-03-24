# Itau API Client for Laravel

This package provides a simple way to interact with the Itau API in your Laravel application.

## Installation

You can install the package via composer:

```bash
composer require itau/client
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Itau\ItauServiceProvider" --tag="config"
```

This will create a `config/itau.php` file where you can set your Itau API credentials.

## Usage

### Getting an Access Token

```php
use Itau\Facades\Itau;

$token = Itau::getToken();
```

### Registering a Payment Slip

```php
use Itau\Facades\Itau;

$data = [];

$response = Itau::registrarBoletoCobranca($data);
```

## Testing

```bash
composer test
```

## License

The MIT License (MIT).
