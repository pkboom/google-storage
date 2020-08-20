<?php

namespace Pkboom\GoogleStorage;

use Illuminate\Support\ServiceProvider;
use Pkboom\GoogleStorage\Facade\Bucket;
use Pkboom\GoogleStorage\Exceptions\InvalidConfiguration;

class GoogleStorageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Bucket::class, function () {
            $config = config('google-storage');

            $this->guardAgainstInvalidConfiguration($config);

            return BucketFactory::create();
        });

        $this->app->alias(Bucket::class, 'laravel-google-storage-bucket');

        $this->mergeConfigFrom(__DIR__.'/../config/google-storage.php', 'google-storage');
    }

    protected function guardAgainstInvalidConfiguration(array $config = null)
    {
        $credentials = $config['service_account_credentials_json'];

        if (!is_array($credentials) && !is_string($credentials)) {
            throw InvalidConfiguration::credentialsTypeWrong($credentials);
        }

        if (is_string($credentials) && !file_exists($credentials)) {
            throw InvalidConfiguration::credentialsJsonDoesNotExist($credentials);
        }
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/google-storage.php' => config_path('google-storage.php'),
        ]);
    }
}
