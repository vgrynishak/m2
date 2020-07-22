<?php

namespace App\App\Handler\Service;

use App\App\Command\Service\CreateServiceCommandInterface;
use App\App\Command\Service\Mapper\ServiceMapperByCommandInterface;
use App\App\Command\Service\Validator\CreateServiceValidatorInterface;
use App\Core\Model\Service\ServiceInterface;
use App\Core\Repository\Service\ServiceCommandRepositoryInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

class CreateServiceCommandHandler
{
    /** @var ServiceCommandRepositoryInterface */
    private $serviceCommandRepository;

    /** @var ManagerRegistry */
    private $registry;

    /** @var CreateServiceValidatorInterface */
    private $createServiceValidator;

    /** @var ServiceMapperByCommandInterface */
    private $serviceMapperByCommand;

    /**
     * CreateServiceCommandHandler constructor.
     * @param ServiceCommandRepositoryInterface $serviceCommandRepository
     * @param ManagerRegistry $registry
     * @param CreateServiceValidatorInterface $createServiceValidator
     * @param ServiceMapperByCommandInterface $serviceMapperByCommand
     */
    public function __construct(
        ServiceCommandRepositoryInterface $serviceCommandRepository,
        ManagerRegistry $registry,
        CreateServiceValidatorInterface $createServiceValidator,
        ServiceMapperByCommandInterface $serviceMapperByCommand
    ) {
        $this->serviceCommandRepository = $serviceCommandRepository;
        $this->registry = $registry;
        $this->createServiceValidator = $createServiceValidator;
        $this->serviceMapperByCommand = $serviceMapperByCommand;
    }

    /**
     * @param CreateServiceCommandInterface $command
     */
    public function __invoke(CreateServiceCommandInterface $command): void
    {
        if (!$this->createServiceValidator->validate($command)) {
            throw new UnrecoverableMessageHandlingException(
                $this->createServiceValidator->getFirstErrorMessage(),
                0
            );
        }

        try {
            /** @var ServiceInterface $service */
            $service = $this->serviceMapperByCommand->map($command);
            $this->serviceCommandRepository->create($service);
        } catch (Exception $exception) {
            $this->registry->resetManager();
            throw new UnrecoverableMessageHandlingException($exception->getMessage(), 0, $exception);
        }
    }
}
