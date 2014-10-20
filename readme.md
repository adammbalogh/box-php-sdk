# Box Sdk

[![Author](http://img.shields.io/badge/author-@adammbalogh-blue.svg?style=flat)](https://twitter.com/adammbalogh)
[![Build Status](https://img.shields.io/travis/adammbalogh/box-php-sdk/master.svg?style=flat)](https://travis-ci.org/adammbalogh/box-php-sdk)
[![Quality Score](https://img.shields.io/scrutinizer/g/adammbalogh/box-php-sdk.svg?style=flat)](https://scrutinizer-ci.com/g/adammbalogh/box-php-sdk)
[![Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/adammbalogh/box-sdk.svg?style=flat)](https://packagist.org/packages/adammbalogh/box-sdk)
[![Total Downloads](https://img.shields.io/packagist/dt/adammbalogh/box-sdk.svg?style=flat)](https://packagist.org/packages/adammbalogh/box-sdk)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/5cde6ee7-5002-43b5-beb7-df12fddc8c15/small.png)](https://insight.sensiolabs.com/projects/5cde6ee7-5002-43b5-beb7-df12fddc8c15)

# Description

This is an unofficial [Box](https://www.box.com/home) Php Sdk.

# Toc

* [Installation](https://github.com/adammbalogh/box-php-sdk#installation)
* [Authorization](https://github.com/adammbalogh/box-php-sdk#authorization)
 * [Authorize](https://github.com/adammbalogh/box-php-sdk#authorize)
 * [Revoke tokens](https://github.com/adammbalogh/box-php-sdk#revoke-tokens)
 * [Get access token Ttl](https://github.com/adammbalogh/box-php-sdk#get-access-token-ttl)
* [Request](https://github.com/adammbalogh/box-php-sdk#request)
 * [Extended Request](https://github.com/adammbalogh/box-php-sdk#extended-request)
* [Response](https://github.com/adammbalogh/box-php-sdk#response)
 * [Handle Response](https://github.com/adammbalogh/box-php-sdk#handle-response)
* [Content Api](https://github.com/adammbalogh/box-php-sdk#content-api)
 * [Create Client](https://github.com/adammbalogh/box-php-sdk#create-client)
 * [Commands](https://github.com/adammbalogh/box-php-sdk#commands)
    * [User Commands](https://github.com/adammbalogh/box-php-sdk#user-commands)
    * [Folder Commands](https://github.com/adammbalogh/box-php-sdk#folder-commands)
    * [File Commands](https://github.com/adammbalogh/box-php-sdk#file-commands)
    * [Search Commands](https://github.com/adammbalogh/box-php-sdk#search-commands)
* [View Api](https://github.com/adammbalogh/box-php-sdk#view-api)
 * [Create Client](https://github.com/adammbalogh/box-php-sdk#create-client-1)
 * [Commands](https://github.com/adammbalogh/box-php-sdk#commands-1)
    * [Document Commands](https://github.com/adammbalogh/box-php-sdk#document-commands)
    * [Session Commands](https://github.com/adammbalogh/box-php-sdk#session-commands)
* [Wrappers](https://github.com/adammbalogh/box-php-sdk#wrappers)

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

# Authorization

Your goal is to obtain a valid access token.

## Authorize

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

## Revoke tokens

```php
$oAuthClient->revokeTokens();
```

## Get access token Ttl

```php
/* @var int $ttl Access token's time to live */
$ttl = $oAuthClient->getAccessTokenTtl();
```

# Request

## Extended Request

Here you can see an example request to the View Api. It calls the UrlDocumentUpload command.

Many of the commands are able to include an Extended Request object. With an Extended Request object you can
inject your extra Headers, Url Parameters or Request Body Attributes.

```php
<?php
use AdammBalogh\Box\ViewClient;
use AdammBalogh\Box\Client\View\ApiClient;
use AdammBalogh\Box\Client\View\UploadClient;
use AdammBalogh\Box\Command\View;
use AdammBalogh\Box\Request\ExtendedRequest;

$apiKey = 'apikey';
$viewClient = new ViewClient(new ApiClient($apiKey), new UploadClient($apiKey));

$er = new ExtendedRequest();
$er->setHeader('Content-Type', 'application/json');
$er->addQueryField('fields', 'status');
$er->setPostBodyField('name', 'file-name');

$command = new View\Document\UrlDocumentUpload('https://cloud.box.com/shared/static/zzxlzc38hq7u1u5jdteu.pdf', $er);
```

# Response

## Handle Response

You can get 5 important response values:
* $response->getStatusCode(); *# e.g. '201'*
* $response->getReasonPhrase(); *# e.g. 'Created'*
* $response->getHeaders(); *# array of response headers ['header name' => 'header value']*
* $response->json(); *# parse json response as an array*
* (string)$response->getBody();

```php
<?php
use AdammBalogh\Box\ViewClient;
use AdammBalogh\Box\Client\View\ApiClient;
use AdammBalogh\Box\Client\View\UploadClient;
use AdammBalogh\Box\Command\View;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$apiKey = 'apikey';
$viewClient = new ViewClient(new ApiClient($apiKey), new UploadClient($apiKey));

$command = new View\Document\ListDocument();
$response = ResponseFactory::getResponse($viewClient, $command);

if ($response instanceof SuccessResponse) {
    $response->getStatusCode();
    $response->getReasonPhrase();
    $response->getHeaders();
    $response->json();
    (string)$response->getBody();
} elseif ($response instanceof ErrorResponse) {
    # same as above
}
```

# Content Api

## Create Client

```php
<?php
use AdammBalogh\Box\ContentClient;
use AdammBalogh\Box\Client\Content\ApiClient;
use AdammBalogh\Box\Client\Content\UploadClient;

$accessToken = 'accesstoken';

$contentClient = new ContentClient(new ApiClient($accessToken), new UploadClient($accessToken));
```

## Commands

### User Commands

#### Get Current User Command

```php
<?php
use AdammBalogh\Box\Command\Content;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new Content\User\GetCurrentUser();
$response = ResponseFactory::getResponse($contentClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

### Folder Commands

#### Copy Folder Command

```php
<?php
use AdammBalogh\Box\Command\Content;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new Content\Folder\CopyFolder('sourceFolderId', 'destinationFolderId');
$response = ResponseFactory::getResponse($contentClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### Create Folder Command

```php
<?php
use AdammBalogh\Box\Command\Content;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new Content\Folder\CreateFolder('folderName', 'parentFolderId');
$response = ResponseFactory::getResponse($contentClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### Create Shared Folder Link Command

```php
<?php
use AdammBalogh\Box\Command\Content;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;
use AdammBalogh\Box\Request\ExtendedRequest;

$er = new ExtendedRequest();
$er->setPostBodyField('shared_link', ['access'=>'open']);

$command = new Content\Folder\CreateSharedFolderLink('folderId', $er);
$response = ResponseFactory::getResponse($contentClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### Delete Folder Command

✔ Extended Request

```php
<?php
use AdammBalogh\Box\Command\Content;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new Content\Folder\DeleteFolder('folderId');
$response = ResponseFactory::getResponse($contentClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### Get Folder Info Command

```php
<?php
use AdammBalogh\Box\Command\Content;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new Content\Folder\GetFolderInfo('folderId');
$response = ResponseFactory::getResponse($contentClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### List Folder Command

✔ Extended Request

```php
<?php
use AdammBalogh\Box\Command\Content;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new Content\Folder\ListFolder('folderId');
$response = ResponseFactory::getResponse($contentClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### List Folder Collaborations Command

```php
<?php
use AdammBalogh\Box\Command\Content;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new Content\Folder\ListFolderCollaborations('folderId');
$response = ResponseFactory::getResponse($contentClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### Update Folder Info Command

```php
<?php
use AdammBalogh\Box\Command\Content;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;
use AdammBalogh\Box\Request\ExtendedRequest;

$er = new ExtendedRequest();
$er->setPostBodyField('name', 'file-name');

$command = new Content\Folder\UpdateFolderInfo('folderId', $er);
$response = ResponseFactory::getResponse($contentClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

### File Commands

#### Copy File Command

```php
<?php
use AdammBalogh\Box\Command\Content;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new Content\File\CopyFile('fileId', 'folderId');
$response = ResponseFactory::getResponse($contentClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### Create Shared File Link Command

```php
<?php
use AdammBalogh\Box\Command\Content;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;
use AdammBalogh\Box\Request\ExtendedRequest;

$er = new ExtendedRequest();
$er->setPostBodyField('shared_link', ['access'=>'open']);

$command = new Content\File\CreateSharedFileLink('fileId', $er);
$response = ResponseFactory::getResponse($contentClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### Delete File Command

✔ Extended Request

```php
<?php
use AdammBalogh\Box\Command\Content;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new Content\File\DeleteFile('fileId');
$response = ResponseFactory::getResponse($contentClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### Download File Command

✔ Extended Request

```php
<?php
use AdammBalogh\Box\Command\Content;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new Content\File\DownloadFile('fileId');
$response = ResponseFactory::getResponse($contentClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### Get File Info Command

```php
<?php
use AdammBalogh\Box\Command\Content;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new Content\File\GetFileInfo('fileId');
$response = ResponseFactory::getResponse($contentClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### Pre Flight Existing File Check Command

```php
<?php
use AdammBalogh\Box\Command\Content;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new Content\File\PreFlightExistingFileCheck('fileId', fileSize);
$response = ResponseFactory::getResponse($contentClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### Pre Flight New File Check Command

```php
<?php
use AdammBalogh\Box\Command\Content;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new Content\File\PreFlightNewFileCheck('fileName', fileSize, 'parentFolderId');
$response = ResponseFactory::getResponse($contentClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### Update File Info Command

```php
<?php
use AdammBalogh\Box\Command\Content;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;
use AdammBalogh\Box\Request\ExtendedRequest;

$er = new ExtendedRequest();
$er->setPostBodyField('name', 'file-name');
$er->setPostBodyField('description', 'file-description');

$command = new Content\File\UpdateFileInfo('fileId', $er);
$response = ResponseFactory::getResponse($contentClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### Upload File Command

```php
<?php
use AdammBalogh\Box\Command\Content;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new Content\File\UploadFile('fileName', 'parentFolderId', 'content');
$response = ResponseFactory::getResponse($contentClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### Upload New File Version Command

✔ Extended Request

```php
<?php
use AdammBalogh\Box\Command\Content;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new Content\File\UploadNewFileVersion('fileId', 'content');
$response = ResponseFactory::getResponse($contentClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

### Search Commands

#### Search Content Command

✔ Extended Request

```php
<?php
use AdammBalogh\Box\Command\Content;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new Content\Search\SearchContent('query');
$response = ResponseFactory::getResponse($contentClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

# View Api

## Create Client

```php
<?php
use AdammBalogh\Box\ViewClient;
use AdammBalogh\Box\Client\View\ApiClient;
use AdammBalogh\Box\Client\View\UploadClient;

$apiKey = 'apikey';

$viewClient = new ViewClient(new ApiClient($apiKey), new UploadClient($apiKey));
```

## Commands

### Document Commands

#### Delete Document Command

```php
<?php
use AdammBalogh\Box\Command\View;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new View\Document\DeleteDocument('documentId');
$response = ResponseFactory::getResponse($viewClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### Get Document Content Command ☢

```php
<?php
use AdammBalogh\Box\Command\View;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new View\Document\GetDocumentContent('documentId', 'zip'); # extension can be '', 'zip' or 'pdf'
$response = $viewClient->request($command);

echo (string)$response->getBody(); # the content of the document
```

#### Get Document Info Command

✔ Extended Request

```php
<?php
use AdammBalogh\Box\Command\View;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new View\Document\GetDocumentInfo('documentId');
$response = ResponseFactory::getResponse($viewClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### Get Document Thumbnail Command

✔ Extended Request

```php
<?php
use AdammBalogh\Box\Command\View;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new View\Document\GetDocumentThumbnail('documentId');
$response = ResponseFactory::getResponse($viewClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### List Document Command

✔ Extended Request

```php
<?php
use AdammBalogh\Box\Command\View;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new View\Document\ListDocument();
$response = ResponseFactory::getResponse($viewClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### Multipart Document Upload Command

✔ Extended Request

```php
<?php
use AdammBalogh\Box\Command\View;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new View\Document\MultipartDocumentUpload('content', 'filename.pdf');
$response = ResponseFactory::getResponse($viewClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### Update Document Info Command

```php
<?php
use AdammBalogh\Box\Command\View;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new View\Document\UpdateDocumentInfo('documentId', 'newFileName');
$response = ResponseFactory::getResponse($viewClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

#### Url Document Upload Command

✔ Extended Request

```php
<?php
use AdammBalogh\Box\Command\View;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new View\Document\UrlDocumentUpload('urlOfTheDocument');
$response = ResponseFactory::getResponse($viewClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

### Session Commands

#### Create Document Session Command

✔ Extended Request

```php
<?php
use AdammBalogh\Box\Command\View;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

$command = new View\Session\CreateDocumentSession('documentId');
$response = ResponseFactory::getResponse($viewClient, $command);

if ($response instanceof SuccessResponse) {
	# ...
} elseif ($response instanceof ErrorResponse) {
	# ...
}
```

# Wrappers

## Search Path Wrapper

It wraps the [Search Content Command](https://github.com/adammbalogh/box-php-sdk#search-content-command) to able to get an Entry object from a path string (like **/root/dir_1/dir_2**, or **/pictures/img.png**)

```php
<?php
use AdammBalogh\Box\Wrapper\SearchPath;
use AdammBalogh\Box\Wrapper\Response\FolderEntry;
use AdammBalogh\Box\Wrapper\Response\FileEntry;


$wrapper = new SearchPath($contentClient);

$entry = $wrapper->getEntry('/my-dir/example_dir');

if ($entry instanceof FolderEntry) {
    $entry->identity; # folderId
    # here you can create your own command, because now you have the folder id!
} elseif ($entry instanceof FileEntry) {
    $entry->identity;
}
```

## Create Folders Wrapper

It wraps the [Create Folder Command](https://github.com/adammbalogh/box-php-sdk#create-folder-command) to able to create folders implicitly.

```php
<?php
use AdammBalogh\Box\Wrapper\CreateFolders;


$wrapper = new CreateFolders($contentClient);

$lastFolderId = $wrapper->create('/dir_1/dir_2/dir_3/dir_4');

# $lastFolderId means dir_4's id
```
