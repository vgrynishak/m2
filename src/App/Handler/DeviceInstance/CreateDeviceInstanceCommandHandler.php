<?php

namespace App\App\Handler\DeviceInstance;

use App\App\Command\DeviceInstance\CreateDeviceInstanceCommandInterface;
use App\App\Command\DeviceInstance\Validator\CreateDeviceInstanceValidatorInterface;
use App\App\UseCase\DeviceInstance\CreateDeviceInstanceUseCaseInterface;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;
use App\Core\Repository\DeviceInstance\DeviceInstanceCommandRepositoryInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

class CreateDeviceInstanceCommandHandler
{
    /** @var CreateDeviceInstanceUseCaseInterface */
    private $createDeviceInstanceUseCase;
    /** @var CreateDeviceInstanceValidatorInterface */
    private $createDeviceInstanceValidator;
    /** @var DeviceInstanceCommandRepositoryInterface */
    private $deviceInstanceCommandRepository;
    /** @var ManagerRegistry */
    protected $registry;

    /**
     * CreateDeviceInstanceHandler constructor.
     * @param CreateDeviceInstanceUseCaseInterface $createDeviceInstanceUseCase
     * @param CreateDeviceInstanceValidatorInterface $createDeviceInstanceValidator
     * @param DeviceInstanceCommandRepositoryInterface $deviceInstanceCommandRepository
     * @param ManagerRegistry $registry
     */
    public function __construct(
        CreateDeviceInstanceUseCaseInterface $createDeviceInstanceUseCase,
        CreateDeviceInstanceValidatorInterface $createDeviceInstanceValidator,
        DeviceInstanceCommandRepositoryInterface $deviceInstanceCommandRepository,
        ManagerRegistry $registry
    ) {
        $this->createDeviceInstanceUseCase = $createDeviceInstanceUseCase;
        $this->createDeviceInstanceValidator = $createDeviceInstanceValidator;
        $this->deviceInstanceCommandRepository = $deviceInstanceCommandRepository;
        $this->registry = $registry;
    }

    /**
     * @param CreateDeviceInstanceCommandInterface $command
     */
    public function __invoke(CreateDeviceInstanceCommandInterface $command): void
    {
        if (!$this->createDeviceInstanceValidator->validate($command)) {
            throw new UnrecoverableMessageHandlingException(
                $this->createDeviceInstanceValidator->getFirstErrorMessage(),
                0
            );
        }

        try {
            /** @var DeviceInstanceInterface $deviceInstance */
            $deviceInstance = $this->createDeviceInstanceUseCase->create($command);

            $this->deviceInstanceCommandRepository->create($deviceInstance);
        } catch (Exception $exception) {
            $this->registry->resetManager();
            throw new UnrecoverableMessageHandlingException($exception->getMessage(), 0, $exception);
        }
    }
}
