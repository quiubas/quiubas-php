# Quiubas PHP Library

## Requirements
- PHP 5.6+
- `openssl` extension
- `curl` extension

## Current version 1.3.1

## Installation

Install **quiubas-php** by downloading the source.

Download the [latest release](https://github.com/quiubas/quiubas-php/zipball/master). Then, to use the library, include the `quiubas.php` file.

```php
require_once '/path/to/quiubas-php/Quiubas.php';
```

## Quickstart

### Send an SMS

```php
<?php
// Install the library by downloading the .zip file to your project folder.
// Load the library
require_once '/path/to/quiubas-php/Quiubas.php';

//Get your keys from user dashboard
\Quiubas\Quiubas::setAuth( 'api_key', 'api_private' );

$response = \Quiubas\Sms::send(array(
  'to_number' => 'phone_number',
  'message' => 'Hello there',
));

echo $response['id'];

$response = \Quiubas\SMS::get(array(
  'id' => 'sms_id'
  ));

$response = \Quiubas\SMS::getAll();

$response = \Quiubas\SMS::getResponses(array(
   'id' => 'sms_id'
));


$response = \Quiubas\MNP::getData(array(
   'number' => 'phone_number'
));

```
