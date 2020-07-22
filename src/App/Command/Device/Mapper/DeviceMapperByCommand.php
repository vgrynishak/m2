<?php

namespace App\App\Command\Device\Mapper;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Device\Device;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Division\DivisionInterface;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\Core\Repository\Division\DivisionQueryRepositoryInterface;
use App\Infrastructure\Exception\Device\FailCreateAction;
use DateTime;

class DeviceMapperByCommand implements DeviceMapperByCommandInterface
{
    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;
    /** @var DivisionQueryRepositoryInterface */
    private $divisionQueryRepository;

    /**
     * CreateDeviceCommandMapper constructor.
     * @param DeviceQueryRepositoryInterface $deviceQueryRepository
     * @param DivisionQueryRepositoryInterface $divisionQueryRepository
     */
    public function __construct(
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        DivisionQueryRepositoryInterface $divisionQueryRepository
    ) {
        $this->deviceQueryRepository = $deviceQueryRepository;
        $this->divisionQueryRepository = $divisionQueryRepository;
    }

    /**
     * @param MessageInterface $command
     * @return DeviceInterface
     * @throws FailCreateAction
     */
    public function map(MessageInterface $command): DeviceInterface
    {
        /** @var DeviceInterface $device */
        $device = $this->deviceQueryRepository->find($command->getId());
        if ($device instanceof DeviceInterface) {
            throw new FailCreateAction('Device have been already created');
        }

        /** @var DivisionInterface $division */
        $division = $this->divisionQueryRepository->find($command->getDivisionId());
        if (!$division instanceof DivisionInterface) {
            throw new FailCreateAction('Invalid division id');
        }

        /** @var DeviceInterface $device */
        $device = new Device(
            $command->getId(),
            $command->getName(),
            $command->getLevel(),
            $command->getDivisionId(),
            $command->getAlias()
        );

        if ($command->getParentId()) {
            /** @var DeviceInterface $parentDevice */
            $parentDevice = $this->deviceQueryRepository->find($command->getParentId());

            if (!$parentDevice instanceof DeviceInterface) {
                throw new FailCreateAction('Invalid parentId');
            }
            $device->setParentId($command->getParentId());
        }
        $device->setDescription($command->getDescription());
        $device->setCreatedBy($command->getCreatedBy());
        $device->setDynamicFields($command->getDynamicFields());

        return $device;
    }
}
