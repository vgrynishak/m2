<?php

namespace App\App\Service\FileStorage;

use App\App\Service\Exception\FailGetObjectS3Storage;
use App\App\Service\Exception\FailPutObjectS3Storage;
use App\Core\Model\File\FileInterface;

interface FileStorageInterface
{
    /**
     * @param FileInterface $file
     * @param string|null $bucket
     * @return void
     */
    public function put(FileInterface $file, ?string $bucket = '') :void;

    /**
     * @param string $key
     * @param string|null $bucket
     * @return FileInterface
     */
    public function get(string $key, ?string $bucket = '') :FileInterface;
}