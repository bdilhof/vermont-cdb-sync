<?php

namespace VermontDevelopment\CdbSync;

use Illuminate\Support\ServiceProvider;
use VermontDevelopment\CdbSync\Commands\CdbSync;
use VermontDevelopment\CdbSync\Commands\Sync;
use VermontDevelopment\CdbSync\Services\CdbService;
use VermontDevelopment\CdbSync\Traits\RegisterMigration;

class CdbServiceProvider extends ServiceProvider
{
    use RegisterMigration;

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {

            // config
            $this->publishes([__DIR__.'/../config/cdb-sync.php' => config_path('cdb-sync.php')], 'cdb-sync.config');

            // migrations
            $this->registerMigration('create_cdb_age_groups_table.php', 'cdb-sync.migrations.age-groups');
            $this->registerMigration('create_cdb_centres_table.php', 'cdb-sync.migrations.centres', '0000_00_00_000001');
            $this->registerMigration('create_cdb_colors_table.php', 'cdb-sync.migrations.colors');
            $this->registerMigration('create_cdb_currencies_table.php', 'cdb-sync.migrations.currencies');
            $this->registerMigration('create_cdb_diagrams_table.php', 'cdb-sync.migrations.diagrams');
            $this->registerMigration('create_cdb_inventory_groups_table.php', 'cdb-sync.migrations.inventory-groups');
            $this->registerMigration('create_cdb_order_groups_table.php', 'cdb-sync.migrations.order-groups');
            $this->registerMigration('create_cdb_seasons_table.php', 'cdb-sync.migrations.seasons');
            $this->registerMigration('create_cdb_sizes_table.php', 'cdb-sync.migrations.sizes');
            $this->registerMigration('create_cdb_countries_table.php', 'cdb-sync.migrations.countries');

            $this->commands([
                CdbSync::class
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        app()->singleton('cdb', function() {
            return new CdbService();
        });
    }
}
