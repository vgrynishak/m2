<?php

namespace App\App\Repository\DeviceInstance;

use App\App\Doctrine\Repository\DeviceInstanceRepository;
use App\App\Mapper\DeviceInstance\DoctrineEntityDeviceInstanceMapperInterface;
use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;
use App\Core\Repository\DeviceInstance\DeviceInstanceQueryRepositoryInterface;
use App\App\Doctrine\Entity\DeviceInstance as DeviceInstanceEntity;

class DeviceInstanceQueryRepository implements DeviceInstanceQueryRepositoryInterface
{
    /** @var DeviceInstanceRepository */
    private $deviceInstanceRepository;
    /** @var DoctrineEntityDeviceInstanceMapperInterface */
    private $doctrineEntityDeviceInstanceMapper;

    /**
     * DeviceInstanceQueryRepository constructor.
     * @param DeviceInstanceRepository $deviceInstanceRepository
     * @param DoctrineEntityDeviceInstanceMapperInterface $doctrineEntityDeviceInstanceMapper
     */
    public function __construct(
        DeviceInstanceRepository $deviceInstanceRepository,
        DoctrineEntityDeviceInstanceMapperInterface $doctrineEntityDeviceInstanceMapper
    ) {
        $this->deviceInstanceRepository = $deviceInstanceRepository;
        $this->doctrineEntityDeviceInstanceMapper = $doctrineEntityDeviceInstanceMapper;
    }

    /**
     * @param DeviceInstanceId $id
     * @return DeviceInstanceInterface|null
     */
    public function find(DeviceInstanceId $id): ?DeviceInstanceInterface
    {
        /** @var DeviceInstanceEntity | null $deviceInstanceEntity */
        $deviceInstanceEntity = $this->deviceInstanceRepository->find($id->getValue());

        if (!$deviceInstanceEntity instanceof DeviceInstanceEntity) {
            return null;
        }

        return $this->doctrineEntityDeviceInstanceMapper->map($deviceInstanceEntity);
    }
}
