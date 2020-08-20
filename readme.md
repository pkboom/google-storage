# Manage Google Storage Bucket for Laravel applications

[![Latest Stable Version](https://poser.pugx.org/pkboom/google-storage/v)](//packagist.org/packages/pkboom/google-storage)
[![Total Downloads](https://poser.pugx.org/pkboom/google-storage/downloads)](//packagist.org/packages/pkboom/google-storage)

This package makes working with Google Storage a breeze. Once it has been set up you can do these things:

## Installation

You can install the package via composer:

```bash
composer require pkboom/google-storage
```

You must publish the configuration with this command:

```bash
php artisan vendor:publish --provider="Pkboom\GoogleStorage\GoogleStorageServiceProvider"
```

This will publish a file called google-storage.php in your config-directory with these contents:

```php
return [
    /*
     * Path to the json file containing the credentials.
     */
    'service_account_credentials_json' => storage_path('app/service-account/credentials.json'),
];
```

## How to obtain the credentials to communicate with Google Storage

[how to obtain the credentials to communicate with google calendar](https://github.com/spatie/laravel-google-calendar#how-to-obtain-the-credentials-to-communicate-with-google-calendar)

[Cloud Storage authentication](https://cloud.google.com/storage/docs/authentication)

## Usage

### Manage buckets

```php
use Pkboom\GoogleStorage\Facades\Bucket;

// buckets list
foreach (Bucket::all() as $bucket) {
    $results[] = $bucket->name();
}

// find a bucket
$bucket = Bucket::find($bucketName);

// objects list
foreach ($bucket->objects() as $object) {
    $results[] = $object->name();
}

// objects with a prefix(directory)
foreach ($bucket->prefix($prefix)->objects() as $object) {
    $results[] = $object->name();
}

// create a bucket
try {
    $bucket = Bucket::create($bucketName);
} catch (Exception $e) {
    return response($e->getMessage(), $e->getCode());
}

// delete a bucket
$bucket->delete();

// upload an object
$bucket->upload($filePath);
$bucket->as($newName)->upload($filePath);

// copy an object
$bucket->copy($bucketName);
$bucket->as('backup/'.$newName)->copy($bucketName);

// move an object
$bucket->move($bucketName);
$bucket->as('backup/'.$newName)->move($bucketName);
```
