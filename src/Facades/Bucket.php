<?php

namespace Pkboom\GoogleStorage\Facades;

use Illuminate\Support\Facades\Facade;

class Bucket extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-google-storage-bucket';
    }
}
