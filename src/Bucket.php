<?php

namespace Pkboom\GoogleStorage;

use Google\Cloud\Storage\StorageClient;

class Bucket
{
    protected $bucket;

    protected $storage;

    protected $object;

    public $options = [];

    public function __construct(StorageClient $storage)
    {
        $this->storage = $storage;
    }

    public function all()
    {
        return $this->storage->buckets();
    }

    public function find($name)
    {
        $this->bucket = $this->storage->bucket($name);

        return $this;
    }

    public function prefix($prefix = null)
    {
        $this->options = ['prefix' => $prefix];

        return $this;
    }

    public function objects()
    {
        return $this->bucket->objects($this->options);
    }

    public function create($name)
    {
        $this->bucket = $this->storage->createBucket($name, $this->options);

        return $this;
    }

    public function delete()
    {
        return $this->bucket->delete();
    }

    public function as($name)
    {
        $this->options = ['name' => $name];

        return $this;
    }

    public function upload($source)
    {
        $file = fopen($source, 'r');

        $this->bucket->upload($file, $this->options);

        return $this;
    }

    public function object($name)
    {
        $this->object = $this->bucket->object($name);

        return $this;
    }

    public function copy($to)
    {
        return $this->object->copy($to, $this->options);
    }

    public function move($to)
    {
        $this->object->copy($to, $this->options);

        return $this->object->delete();
    }

    public function __call($method, $parameters)
    {
        return $this->bucket->{$method}(...$parameters);
    }
}
