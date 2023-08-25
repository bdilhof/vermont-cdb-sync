<?php

namespace VermontDevelopment\CdbSync\Facades;

use \Illuminate\Support\Facades\Facade;

class CdbFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return \VermontDevelopment\CdbSync\Services\CdbService::class;
    }
}
