<?php

namespace App\App\Command\DeviceInstance\Mapper;

use App\App\Component\Message\MessageInterface;
use App\App\Factory\DeviceInstance\DeviceInstanceFactoryInterface;
use App\Core\Model\Device\Device;
use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;

class DeviceInstanceMapperByCommand implements DeviceInstanceMapperByCommandInterface
{
    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;
    /** @var DeviceInstanceFactoryInterface */
    private $deviceInstanceFactory;

    /**
     * DeviceInstanceMapperByCommand constructor.
     * @param DeviceQueryRepositoryInterface $deviceQueryRepository
     * @param DeviceInstanceFactoryInterface $deviceInstanceFactory
     */
    public function __construct(
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        DeviceInstanceFactoryInterface $deviceInstanceFactory
    ) {
        $this->deviceQueryRepository = $deviceQueryRepository;
        $this->deviceInstanceFactory = $deviceInstanceFactory;
    }

    /**
     * @param MessageInterface $command
     * @return DeviceInstanceInterface
     */
    public function map(MessageInterface $command): DeviceInstanceInterface
    {
        /** @var Device $device */
        $device = $this->deviceQueryRepository->find($command->getDeviceId());
        /** @var DeviceInstanceInterface $deviceInstance */
        $deviceInstance = $this->deviceInstanceFactory->make(
            $command->getId(),
            $device,
            $command->getFacilityId()
        );
        $this->mapBaseFields($command, $deviceInstance);

        return $deviceInstance;
    }

    /**
     * @param MessageInterface $command
     * @param DeviceInstanceInterface $deviceInstance
     */
    private function mapBaseFields(MessageInterface $command, DeviceInstanceInterface $deviceInstance): void
    {
        $deviceInstance->setCreatedBy($command->getCreatedBy());
        $deviceInstance->setModifiedBy($command->getModifiedBy());
        /** @var DeviceInstanceId | null $parentId */
        $parentId = $command->getParentId();
        if ($parentId instanceof DeviceInstanceId) {
            $deviceInstance->setParentId($parentId);
        }
    }
}
