<?php

namespace Pkboom\GoogleStorage;

use Google\Cloud\Storage\StorageClient;

class BucketFactory
{
    public static function create()
    {
        $credentials = [
            'keyFilePath' => storage_path('app/google-storage/service-account-credentials.json'),
        ];

        $storage = new StorageClient($credentials);

        return new Bucket($storage);
    }
}
