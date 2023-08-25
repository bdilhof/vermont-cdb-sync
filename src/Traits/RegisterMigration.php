<?php

namespace VermontDevelopment\CdbSync\Traits;

trait RegisterMigration
{
    public function registerMigration($migration, $group, $orderTimestamp = '0000_00_00_000000')
    {
        $source = __DIR__ . '/../../database/migrations/' . $migration;
        $target = database_path('migrations') . '/' . $orderTimestamp . '_' . $migration;

        $this->publishes([$source => $target], $group);
    }
}
