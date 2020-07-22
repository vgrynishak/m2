<?php

namespace App\App\UseCase\DeviceInstance;

use App\App\Command\DeviceInstance\CreateDeviceInstanceCommandInterface;
use App\App\Command\DeviceInstance\Mapper\DeviceInstanceMapperByCommandInterface;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;
use DateTime;
use Exception;

class CreateDeviceInstanceUseCase implements CreateDeviceInstanceUseCaseInterface
{
    /** @var DeviceInstanceMapperByCommandInterface */
    private $mapperByCommand;

    /**
     * CreateDeviceInstanceUseCase constructor.
     * @param DeviceInstanceMapperByCommandInterface $mapperByCommand
     */
    public function __construct(DeviceInstanceMapperByCommandInterface $mapperByCommand)
    {
        $this->mapperByCommand = $mapperByCommand;
    }

    /**
     * @param CreateDeviceInstanceCommandInterface $command
     * @return DeviceInstanceInterface
     * @throws Exception
     */
    public function create(CreateDeviceInstanceCommandInterface $command): DeviceInstanceInterface
    {
        /** @var DeviceInstanceInterface $deviceInstance */
        $deviceInstance = $this->mapperByCommand->map($command);
        $deviceInstance->setModifiedBy($command->getCreatedBy());
        $deviceInstance->setCreatedAt(new DateTime());
        $deviceInstance->setModifiedAt($deviceInstance->getCreatedAt());

        return $deviceInstance;
    }
}
