<?php

namespace App\App\Query\Device\Validator;

use App\Core\Model\Device\DeviceId;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use PhpCollection\CollectionInterface;

abstract class BaseGroupValidator
{
    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;

    /**
     * BaseGroupValidator constructor.
     * @param DeviceQueryRepositoryInterface $deviceQueryRepository
     */
    public function __construct(DeviceQueryRepositoryInterface $deviceQueryRepository)
    {
        $this->deviceQueryRepository = $deviceQueryRepository;
    }

    public function baseValidate(DeviceId $deviceId): void
    {
        $device     = $this->deviceQueryRepository->find($deviceId);

        if (!$device instanceof DeviceInterface) {
            throw new \InvalidArgumentException('Device is not found');
        }

        $deviceTree = $this->deviceQueryRepository->getTree();

        if (!$deviceTree instanceof CollectionInterface) {
            throw new \InvalidArgumentException(
                'Device tree is not exist'
            );
        }
    }
}
