# laravel-sagepayments
PHP SDK for working with basic Sage Payment Bankcard methods.

For more information visit [Sage Payments](https://developer.sagepayments.com/bankcard/apis)

  - [Installation](#installation)
    - [Configuration](#configuration)
    - [Service Provider](#service-provider)
  - [Usage](#usage)
    - [Create Charge](#create-charge)
    - [Return Charges](#return-charges)
    - [Return Charge Details](#return-charge-details)


# Installation
```shell
$ composer require midwesterninteractive/laravel-sagepayments
$ php artisan vendor:publish --tag=config
```

## Configuration
You may modify the config file that is published `config/sagepayments.php` and provide the default options or add the following to your `.env` file:
```
# Merchant/Client
SAGE_MERCH_ID=[sage-client-id]
SAGE_MERCH_KEY=[sage-client-key]

# Sage App
SAGE_APP_ID=[sage-app-id]
SAGE_APP_KEY=[sage-app-key]
```
You'll need to get the Sage Merch creds from your client or login to your Sage Portal. You may also request that Sage set up a test client for development.

For your Sage App creds you'll need to login to your [developer account](https://developer.sagepayments.com/) and grab them from your exisiting application or create a new one.

## Service Provider
If you're on laravel 5.5 the service provider will be automatially loaded, if not, add to your `config/app.php` providers
```php
'providers' => [
    // ...
    MidwesternInteractive\Laravel\SagePaymentsServiceProvider::class,
],
```

# Usage
Use in class
```php
use MidwesternInteractive\Laravel\SagePayments;
```

### Create Charge
Utilizes `post_charges` for more information on available parameters visit the [documentation](https://developer.sagepayments.com/bankcard/apis/post/charges)

```php
$data = [
    'retail' => [
        'amounts' => [
            'total' => 100
        ],
        'billing' => [
            'name' => 'John Smith',
            'address' => '123 Address Ave',
            'city' => 'City',
            'state' => 'ST',
            'postalCode' => '12345',
            'country' => 'US'
        ],
        'cardData' => [
            'number' => '5454545454545454',
            'expiration' => '0920',
            'cvv' => '987'
        ]
    ]
];
$type = 'Sale';

$response = SagePayments::create($data, $type);
```

### Return Charges
Utilizes `get_charges` for more information on available parameters visit the [documentation](https://developer.sagepayments.com/bankcard/apis/get/charges)

```php
$data = [
    'pageSize' => '20'
];

$response = SagePayments::charges($data);
```

### Return Charge Details
Utilizes `get_charges_detail` for more information on available parameters visit the [documentation](https://developer.sagepayments.com/bankcard/apis/get/charges/%7Breference%7D)

```php
// Charge ID
$reference = '[charge-reference-id]';

$response = SagePayments::details($reference);
```