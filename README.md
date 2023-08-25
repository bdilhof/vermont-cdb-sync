# Vermont CDB Sync

Out-of-the-box synchronization with Vermont Central Database

## Installation

This is private repository. Before installation you have to set composer github-oath (
see [authentication for private packages](https://getcomposer.org/doc/articles/authentication-for-private-packages.md#github-oauth)
for more details)

```bash
composer config --global github-oauth.github.com [YOUR-TOKEN-HERE]
```

Once you are done, add vcs type repository to composer.json file

```
"repositories": [
    {
        "type": "vcs",
        "url":  "https://github.com/vermontdevelopment/cdb-sync.git"
    }
]
```

Install package. For latest development version, require version **dev-master** which means the latest commit in the
master branch. Remember, it's on your own risk!

```
composer require vermontdevelopment/cdb-sync
```

Publish package config

```
php artisan vendor:publish --tag=cdb-sync.config
```

Add CDB credentials into .env file

```
CDB_URL=
CDB_SSL_VERIFY=
CDB_KEY=
CDB_SECRET=
```

> dont forget .env.example

### <a name="migrations"></a>Migrations

Migrations are tagged. Publish and run only those tables, you would use in your child project. Options:

```bash
php artisan vendor:publish --tag=cdb-sync.migrations.age-groups
php artisan vendor:publish --tag=cdb-sync.migrations.centres
php artisan vendor:publish --tag=cdb-sync.migrations.colors
php artisan vendor:publish --tag=cdb-sync.migrations.countries
php artisan vendor:publish --tag=cdb-sync.migrations.currencies
php artisan vendor:publish --tag=cdb-sync.migrations.diagrams
php artisan vendor:publish --tag=cdb-sync.migrations.inventory-groups
php artisan vendor:publish --tag=cdb-sync.migrations.order-groups
php artisan vendor:publish --tag=cdb-sync.migrations.seasons
php artisan vendor:publish --tag=cdb-sync.migrations.sizes
```

#### Migration dependencies

Please note that some migrations are dependant on others. To create cdb_centres table, you would need to create cdb_countries table first.

### Syncing files

Some models e.g. Diagrams contain files so to properly sync it, you need create symlink to public storage folder.

```
php artisan storage:link
```

See more about file storage: https://laravel.com/docs/9.x/filesystem#the-public-disk

## Usage

> You may have to publish and run optional database migrations. [Learn more](#migrations)

### CLI

```bash
php artisan cdb:sync {table}
```

#### Available arguments

- age-groups
- centres
- colors
- countries
- currencies
- diagrams
- inventory-groups
- order-groups
- seasons
- sizes

### Scheduled task

```php
class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('cdb:sync age-groups')->daily();
        $schedule->command('cdb:sync centres')->daily();
        $schedule->command('cdb:sync colors')->daily();
        $schedule->command('cdb:sync countries')->daily();
        $schedule->command('cdb:sync currencies')->daily();
        $schedule->command('cdb:sync diagrams')->daily();
        $schedule->command('cdb:sync inventory-groups')->daily();
        $schedule->command('cdb:sync order-groups')->daily();
        $schedule->command('cdb:sync seasons')->daily();
        $schedule->command('cdb:sync sizes')->daily();
    }
}

```

## Facade

```php
CdbSync::SyncOrderGroups();
```

## Extending package models

If you need to do something special like adding new relationship, or method, then create your own model class and extend
origin model

```php
<?php

namespace App\Models;

use VermontDevelopment\CdbSync\Models\Centre as VermontCentre;

class Centre extends VermontCentre
{

}
```

# Note on updates

When updating package, publish config in force mode and then manually compare changes with version control system

```bash
php artisan vendor:publish --tag=cdb-sync.config --force
```
