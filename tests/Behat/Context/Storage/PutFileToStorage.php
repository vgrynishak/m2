<?php

namespace App\Tests\Behat\Context\Storage;

use App\App\Service\Exception\FailPutObjectS3Storage;
use App\App\Service\FileStorage\FileStorageInterface;
use App\App\Service\FileStorage\S3Storage;
use App\Core\Model\File\File;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PutFileToStorage implements Context
{
    const KEY = 'test_key';
    const PHOTO_PATH = '/test_photo.webp';

    /** @var  S3Storage */
    private $fileStorage;
    /** @var File */
    private $file;
    /** @var JsonResponse */
    private $response;

    public function __construct(
        FileStorageInterface $fileStorage
    )
    {
        $this->fileStorage = $fileStorage;
    }

    /**
     * @Given File param with file.data and file.key
     */
    public function fileParamWithFileDataAndFileKey()
    {
        $file = new File(self::KEY, fopen(__DIR__.self::PHOTO_PATH, 'r'));
        $this->file = $file;
    }

    /**
     * @When I Call method put
     */
    public function iCallMethodPut()
    {
        try {
            $this->fileStorage->put($this->file);
            $this->response = new JsonResponse(
                'success',
                Response::HTTP_OK
            );
        } catch (FailPutObjectS3Storage $exception) {
            $this->response = new JsonResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param  $status
     * @Then I should result Response with status :arg1
     */
    public function iShouldResultResponseWithStatus($status)
    {
        Assert::assertEquals($this->response->getStatusCode(), $status);
    }
}
