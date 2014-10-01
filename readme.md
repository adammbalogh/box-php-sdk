# Box Sdk

[![Author](http://img.shields.io/badge/author-@adammbalogh-blue.svg?style=flat)](https://twitter.com/adammbalogh)
[![Build Status](https://img.shields.io/travis/adammbalogh/box-php-sdk/master.svg?style=flat)](https://travis-ci.org/adammbalogh/box-php-sdk)
[![Quality Score](https://img.shields.io/scrutinizer/g/adammbalogh/box-php-sdk.svg?style=flat)](https://scrutinizer-ci.com/g/adammbalogh/box-php-sdk)
[![Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/adammbalogh/box-sdk.svg?style=flat)](https://packagist.org/packages/adammbalogh/box-sdk)
[![Total Downloads](https://img.shields.io/packagist/dt/adammbalogh/box-sdk.svg?style=flat)](https://packagist.org/packages/adammbalogh/box-sdk)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/5cde6ee7-5002-43b5-beb7-df12fddc8c15/small.png)](https://insight.sensiolabs.com/projects/5cde6ee7-5002-43b5-beb7-df12fddc8c15)

# Description

This is an unofficial [Box](https://www.box.com/home) php sdk.

# Skills

* Authorization (OAuth 2.0)
* Content Api
* View Api

# Support

[![Support with Gittip](http://img.shields.io/gittip/adammbalogh.svg?style=flat)](https://www.gittip.com/adammbalogh/)

# Installation

Install it through composer.

```json
{
    "require": {
        "adammbalogh/box-sdk": "@stable"
    }
}
```

**tip:** you should browse the [`adammbalogh/box-sdk`](https://packagist.org/packages/adammbalogh/box-sdk)
page to choose a stable version to use, avoid the `@stable` meta constraint.

# Skills

## Authorization

Your goal is to obtain a valid access token.

### Authorize

```php
<?php

use AdammBalogh\Box\Client\OAuthClient;
use AdammBalogh\KeyValueStore\KeyValueStore;
use AdammBalogh\KeyValueStore\Adapter\NullAdapter;
use AdammBalogh\Box\Exception\ExitException;
use AdammBalogh\Box\Exception\OAuthException;
use GuzzleHttp\Exception\ClientException;


$clientId = 'clientid';
$clientSecret = 'clientsecret';
$redirectUri = 'http://example.com/my-box-app.php';

$keyValueStore = new KeyValueStore(new NullAdapter());

$oAuthClient = new OAuthClient($keyValueStore, $clientId, $clientSecret, $redirectUri);

try {
	$oAuthClient->authorize();
} catch (ExitException $e) {
	# Location header has set (box's authorize page)
	# Instead of an exit call it throws an ExitException
	exit;
} catch (OAuthException $e) {
	# e.g. Invalid user credentials
	# e.g. The user denied access to your application
} catch (ClientException $e) {
	# e.g. if $_GET['code'] is older than 30 sec
}

$accessToken = $oAuthClient->getAccessToken();
```

The ```$keyValueStore``` object is responsible for obtain/save the access token. The example above uses a ```NullAdapter``` for a ```KeyValueStore```, this means it does not obtain or save anything, so authorizes on each call.

If you want to save the access (and the refresh) token persistently, you should check the other adapters of the [KeyValueStore](https://github.com/adammbalogh/key-value-store) package, [here](https://github.com/adammbalogh/key-value-store#adapters).

### Revoke tokens

```php
$oAuthClient->revokeTokens();
```

### Get access token Ttl

```php
/* @var int $ttl Access token's time to live */
$ttl = $oAuthClient->getAccessTokenTtl();
```

## Content Api

*wip*

## View Api

*wip*
