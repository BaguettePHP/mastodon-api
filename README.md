# Baguette PHP Mastodon API Client / SDK

[![Package version](http://img.shields.io/packagist/v/zonuexe/mastodon-api.svg?style=flat)](https://packagist.org/packages/zonuexe/mastodon-api)
[![Packagist](http://img.shields.io/packagist/dt/zonuexe/mastodon-api.svg?style=flat)](https://packagist.org/packages/zonuexe/mastodon-api)
[![Build Status](https://travis-ci.org/BaguettePHP/mastodon-api.svg?branch=master)](https://travis-ci.org/BaguettePHP/mastodon-api)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/BaguettePHP/mastodon-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/BaguettePHP/mastodon-api/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/BaguettePHP/mastodon-api/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/BaguettePHP/mastodon-api/?branch=master)
[![Code Climate](https://codeclimate.com/github/BaguettePHP/mastodon-api.svg)](https://codeclimate.com/github/BaguettePHP/mastodon-api)

## Installation

```
$ composer require zonuexe/mastodon-api
```

## Requires

* PHP 5.5, 5.6, 7.0, 7.1, HHVM
* [Composer](https://getcomposer.org/)

## Features

* IDE (PhpStorm) friendly class/function definitions
* Support [multiparadigm programming](https://en.wikipedia.org/wiki/Programming_paradigm) style (procedural vs OOP)

## Usage

### Simple procedural style

```php
<?php

use Baguette\Mastodon as m;

$service = m\session(
    'pawoo.net', $client_id, $client_secret,
    [
        'scope' => 'read write follow',
        'grant' => ['username' => $username, 'password' => $password],
    ]
);

// Get account by ID
$account = $service->getAccount(42);

// Toot!
$status = $service->postStatus(m\toot('トゥートゥー'));
```

### Manually API request

If you want to request unimplemented APIs in this SDK, you can write the request manually.  This technique is also useful when requesting instance-specific APIs.

```php
<?php

use Baguette\Mastodon as m;

$service = m\session(
    'pawoo.net', $client_id, $client_secret,
    [
        // ...
    ]
);

/** @var m\Entity\Account */
$entity = m\request($service, 'GET', '/api/v1/accounts/29', [], m\Entity\Account::class);

// If you are a PhpStorm user, you can safely type the variable in the action of `/** @var */`.
// Probably the following code will be fill with methods and properties by code completion.
$entity->█
```

## Status of implementations

* [x] GET /api/v1/accounts/:id `Account Mastodon::getAccount(int $id)`
* [x] GET /api/v1/accounts/verify_credentials `Account Mastodon::getAccountCurrentUser()`
* [x] PATCH /api/v1/accounts/update_credentials  `Account Mastodon::updateAccount(array $update_data)`
* [x] GET /api/v1/accounts/:id/followers `Account[] getAccountFollowers(int $account_id)`
* [ ] GET /api/v1/accounts/:id/following
* [ ] GET /api/v1/accounts/:id/statuses
* [ ] POST /api/v1/accounts/:id/follow
* [ ] POST /api/v1/accounts/:id/unfollow
* [ ] GET /api/v1/accounts/:id/block
* [ ] GET /api/v1/accounts/:id/unblock
* [ ] GET /api/v1/accounts/:id/mute
* [ ] GET /api/v1/accounts/:id/unmute
* [ ] GET /api/v1/accounts/relationships
* [ ] GET /api/v1/accounts/search
* [ ] POST /api/v1/apps
* [x] GET /api/v1/blocks `Account[] getBlocks(array $options = [])`
* [x] GET /api/v1/favourites `Status[] getFavourites(array $options = [])`
* [x] GET /api/v1/follow_requests `Account[] getFollowRequests(array $options = [])`
* [ ] POST /api/v1/follow_requests/:id/authorize
* [ ] POST /api/v1/follow_requests/:id/reject
* [ ] POST /api/v1/follows
* [ ] GET /api/v1/instance
* [ ] POST /api/v1/media
* [ ] GET /api/v1/mutes
* [ ] GET /api/v1/notifications
* [ ] GET /api/v1/notifications/:id
* [ ] POST /api/v1/notifications/clear
* [ ] GET /api/v1/reports
* [ ] POST /api/v1/reports
* [ ] GET /api/v1/search
* [x] GET /api/v1/statuses/:id `Status getStatus($status_id)`
* [ ] GET /api/v1/statuses/:id/context
* [ ] GET /api/v1/statuses/:id/card
* [ ] GET /api/v1/statuses/:id/reblogged_by
* [ ] GET /api/v1/statuses/:id/favourited_by
* [x] POST /api/v1/statuses `Status Mastodon::postStatus(Toot $toot)`
* [ ] DELETE /api/v1/statuses/:id
* [ ] POST /api/v1/statuses/:id/reblog
* [ ] POST /api/v1/statuses/:id/unreblog
* [ ] POST /api/v1/statuses/:id/favourite
* [ ] POST /api/v1/statuses/:id/unfavourite
* [ ] GET /api/v1/timelines/home
* [ ] GET /api/v1/timelines/public
* [ ] GET /api/v1/timelines/tag/:hashtag

Copyright
---------

**Baguette\\Mastodon** is licensed under [GNU General Public License, Version 3.0](https://www.gnu.org/licenses/gpl-3.0.html). See `./LICENSE`.

    Baguette Mastodon - Mastodon API Client for PHP
    Copyright (c) 2016 Baguette HQ / USAMI Kenta <tadsan@zonu.me>
