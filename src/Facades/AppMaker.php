<?php

namespace SimpleCom\AppMaker\Facades;

use Illuminate\Support\Facades\Facade;

class AppMaker extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'appmaker';
    }
}
