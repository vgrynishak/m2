<?php

namespace App\App\Handler\ServiceInstance;

use App\App\Command\ServiceInstance\CreateServiceInstanceCommandInterface;
use App\App\Command\ServiceInstance\Validator\CreateServiceInstanceValidatorInterface;
use App\App\UseCase\ServiceInstance\CreateServiceInstanceUseCaseInterface;
use App\Core\Model\ServiceInstance\ServiceInstanceInterface;
use App\Core\Repository\ServiceInstance\ServiceInstanceCommandRepositoryInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

class CreateServiceInstanceCommandHandler
{
    /** @var CreateServiceInstanceUseCaseInterface */
    private $createServiceInstanceUseCase;
    /** @var ServiceInstanceCommandRepositoryInterface */
    private $serviceInstanceCommandRepository;
    /** @var ManagerRegistry */
    protected $registry;
    /** @var CreateServiceInstanceValidatorInterface */
    private $createServiceInstanceValidator;

    /**
     * CreateServiceInstanceCommandHandler constructor.
     * @param CreateServiceInstanceUseCaseInterface $createServiceInstanceUseCase
     * @param ServiceInstanceCommandRepositoryInterface $serviceInstanceCommandRepository
     * @param ManagerRegistry $registry
     * @param CreateServiceInstanceValidatorInterface $createServiceInstanceValidator
     */
    public function __construct(
        CreateServiceInstanceUseCaseInterface $createServiceInstanceUseCase,
        ServiceInstanceCommandRepositoryInterface $serviceInstanceCommandRepository,
        ManagerRegistry $registry,
        CreateServiceInstanceValidatorInterface $createServiceInstanceValidator
    ) {
        $this->createServiceInstanceUseCase = $createServiceInstanceUseCase;
        $this->serviceInstanceCommandRepository = $serviceInstanceCommandRepository;
        $this->registry = $registry;
        $this->createServiceInstanceValidator = $createServiceInstanceValidator;
    }

    /**
     * @param CreateServiceInstanceCommandInterface $command
     */
    public function __invoke(CreateServiceInstanceCommandInterface $command): void
    {
        if (!$this->createServiceInstanceValidator->validate($command)) {
            throw new UnrecoverableMessageHandlingException(
                $this->createServiceInstanceValidator->getFirstErrorMessage(),
                0
            );
        }

        try {
            /** @var ServiceInstanceInterface $serviceInstance */
            $serviceInstance = $this->createServiceInstanceUseCase->create($command);

            $this->serviceInstanceCommandRepository->create($serviceInstance);
        } catch (Exception $exception) {
            $this->registry->resetManager();
            throw new UnrecoverableMessageHandlingException($exception->getMessage(), 0, $exception);
        }
    }
}
