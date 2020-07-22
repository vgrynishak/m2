<?php

namespace App\App\UseCase\ServiceInstance;

use App\App\Command\ServiceInstance\CreateServiceInstanceCommandInterface;
use App\App\Command\ServiceInstance\Mapper\ServiceInstanceMapperByCommandInterface;
use App\Core\Model\ServiceInstance\ServiceInstanceInterface;
use DateTime;
use Exception;

class CreateServiceInstanceUseCase implements CreateServiceInstanceUseCaseInterface
{
    /** @var ServiceInstanceMapperByCommandInterface */
    private $mapperByCommand;

    /**
     * CreateServiceInstanceUseCase constructor.
     * @param ServiceInstanceMapperByCommandInterface $mapperByCommand
     */
    public function __construct(ServiceInstanceMapperByCommandInterface $mapperByCommand)
    {
        $this->mapperByCommand = $mapperByCommand;
    }

    /**
     * @param CreateServiceInstanceCommandInterface $command
     * @return ServiceInstanceInterface
     * @throws Exception
     */
    public function create(CreateServiceInstanceCommandInterface $command): ServiceInstanceInterface
    {
        /** @var ServiceInstanceInterface $serviceInstance */
        $serviceInstance = $this->mapperByCommand->map($command);
        $serviceInstance->setModifiedBy($command->getCreatedBy());
        $serviceInstance->setCreatedAt(new DateTime());
        $serviceInstance->setModifiedAt($serviceInstance->getCreatedAt());

        return $serviceInstance;
    }
}
