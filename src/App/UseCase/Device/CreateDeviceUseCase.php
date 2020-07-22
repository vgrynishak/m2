<?php

namespace App\App\UseCase\Device;

use App\App\Command\Device\CreateDeviceCommandInterface;
use App\App\Command\Device\Mapper\DeviceMapperByCommandInterface;
use App\Core\Model\Device\DeviceInterface;
use DateTime;
use Exception;

class CreateDeviceUseCase implements CreateDeviceUseCaseInterface
{
    /** @var DeviceMapperByCommandInterface */
    private $deviceMapperByCommand;

    /**
     * CreateDeviceUseCase constructor.
     * @param DeviceMapperByCommandInterface $deviceMapperByCommand
     */
    public function __construct(DeviceMapperByCommandInterface $deviceMapperByCommand)
    {
        $this->deviceMapperByCommand = $deviceMapperByCommand;
    }

    /**
     * @param CreateDeviceCommandInterface $command
     * @return DeviceInterface
     * @throws Exception
     */
    public function create(CreateDeviceCommandInterface $command): DeviceInterface
    {
        /** @var DeviceInterface $device */
        $device = $this->deviceMapperByCommand->map($command);
        $device->setModifiedBy($command->getCreatedBy());
        $device->setCreatedAt(new DateTime());
        $device->setUpdatedAt($device->getCreatedAt());

        return $device;
    }
}
