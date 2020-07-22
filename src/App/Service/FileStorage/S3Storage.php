<?php

namespace App\App\Service\FileStorage;

use App\App\Service\Exception\FailGetObjectS3Storage;
use App\App\Service\Exception\FailPutObjectS3Storage;
use App\Core\Model\File\File;
use App\Core\Model\File\FileInterface;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

class S3Storage implements FileStorageInterface
{
    use ContainerAwareTrait;

    /** @var S3Client */
    private $client;

    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
        $this->client = $this->getClient();
    }

    private function getClient()
    {
        return new S3Client(array(
            'region'    => 'eu-central-1',
            'version'   => 'latest',
            'signature_version' => 'v4',
            'credentials'   => array(
                'key'       => $this->container->getParameter('s3_public_key'),
                'secret'    => $this->container->getParameter('s3_private_key'),
            )
        ));
    }

    /**
     * @param string $key
     * @param string|null $bucket
     * @return FileInterface
     * @throws FailGetObjectS3Storage
     */
    public function get(string $key, ?string $bucket = 'idaptest'): FileInterface
    {
        try {
            $result = $this->client->getObject([
                'Bucket' => $bucket,
                'Key'    => $key
            ]);

            if (!isset($result['Body'], $result['@metadata']['effectiveUri'])) {
                throw new FailGetObjectS3Storage('incorrect response'.print_r($result, true));
            }

            $file =  new File($key, $result['Body']);
            $file->setLink($result['@metadata']['effectiveUri']);

            return $file;

        } catch (S3Exception $exception) {
            throw new FailGetObjectS3Storage($exception->getMessage());
        }
    }

    /**
     * @param FileInterface $file
     * @param string|null $bucket
     * @throws FailPutObjectS3Storage
     */
    public function put(FileInterface $file, ?string $bucket = 'idaptest'): void
    {
        try {
            $this->client->putObject([
                'Bucket' => $bucket,
                'Key'    => $file->getKey(),
                'Body'   => $file->getData()
            ]);
        } catch (S3Exception $exception) {
            throw new FailPutObjectS3Storage($exception->getMessage());
        }
    }
}