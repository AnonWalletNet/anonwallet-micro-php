# anonwallet-php

Official PHP SDK of AnonWallet.Net Anonymous Cryptocurrency Payment Gateway for sending Micro Transactions

## Install guide
You can install anonwallet plugin using composer in your project using:

```
composer require anonwallet_micro/anonwallet-micro-php
```

## Usage
Include namespace of package wherever you want to use this library

```
include_once './vendor/autoload.php';
use AnonWallet\AnonWallet_micro;

$api_key = 'Your merchant API Key';

$obj = new AnonWallet($api_key);
```

## Get Balance of specific coin

```

$currency = 'BTC'; //If currency parameter is not specified, default currency is BTC

$balance = $obj->balance($currency);
```

## Get currencies available

```
$currencies = $obj->currencies();
```

## Check linked address

```
$currency = 'BTC'; //If currency parameter is not specified, default currency is BTC
$address = '1Btcdemoforwardaddress'; // Linked address if it belongs to AnonWallet Micro Payments system

$address = $obj->check_address($currency, $address);
```

## Send a payment

```
$currency = 'BTC'; //If currency parameter is not specified, default currency is BTC
$amount = '0.01'; // Numeric double amount to be send from your account
$address = '1Btcdemowithdrawaladdress'; //The receiver address

$send = $obj->send($currency, $amount, $address);
```

**You can find more references on our API Documentation (https://anonwallet.readme.io)**
