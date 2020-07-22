<?php

namespace App\Tests\Behat\Context\Storage;

use App\App\Service\Exception\FailGetObjectS3Storage;
use App\App\Service\FileStorage\FileStorageInterface;
use App\App\Service\FileStorage\S3Storage;
use App\Core\Model\File\File;
use Behat\Behat\Context\Context;

class GetFileFromStorage implements Context
{
    /** @var  S3Storage */
    private $fileStorage;
    /** @var string */
    private $key;
    private $response;

    const KEY       = 'test_key';
    const ERROR_KEY = 'error_key';

    public function __construct(
        FileStorageInterface $fileStorage
    )
    {
        $this->fileStorage = $fileStorage;
    }

    /**
     * @Given param key with existing file
     */
    public function paramKeyWithExistingFile()
    {
        $this->key = self::KEY;
    }

    /**
     * @When I Call method get
     */
    public function iCallMethodGet()
    {
        try {
            $this->response = $this->fileStorage->get($this->key);

        } catch (FailGetObjectS3Storage $exception) {
            return $this->response = $exception;
        }
    }

    /**
     * @Then I should get File
     */
    public function iShouldGetFile()
    {
        if (!$this->response instanceof File) {
            return false;
        }

        return true;
    }

    /**
     * @Given param key without existing file
     */
    public function paramKeyWithoutExistingFile()
    {
        $this->key = self::ERROR_KEY;
    }

    /**
     * @Then I should get Exception FailGetObjectS3Storage
     */
    public function iShouldGetException()
    {
        if (!$this->response instanceof FailGetObjectS3Storage) {
            return false;
        }

        return true;
    }
}
