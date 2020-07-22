<?php

namespace App\App\Handler\Device;

use App\App\Command\Device\CreateDeviceCommandInterface;
use App\App\Command\Device\Validator\CreateDeviceValidatorInterface;
use App\App\UseCase\Device\CreateDeviceUseCaseInterface;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Repository\Device\DeviceCommandRepositoryInterface;
use Exception;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

class CreateDeviceHandler implements MessageHandlerInterface
{
    /** @var DeviceCommandRepositoryInterface */
    private $deviceCommandRepository;
    /** @var ManagerRegistry */
    protected $registry;
    /** @var CreateDeviceValidatorInterface */
    private $createDeviceValidator;
    /** @var CreateDeviceUseCaseInterface */
    private $createDeviceUseCase;

    /**
     * CreateDeviceHandler constructor.
     * @param DeviceCommandRepositoryInterface $deviceCommandRepository
     * @param ManagerRegistry $registry
     * @param CreateDeviceValidatorInterface $createDeviceValidator
     * @param CreateDeviceUseCaseInterface $createDeviceUseCase
     */
    public function __construct(
        DeviceCommandRepositoryInterface $deviceCommandRepository,
        ManagerRegistry $registry,
        CreateDeviceValidatorInterface $createDeviceValidator,
        CreateDeviceUseCaseInterface $createDeviceUseCase
    ) {
        $this->deviceCommandRepository = $deviceCommandRepository;
        $this->registry = $registry;
        $this->createDeviceValidator = $createDeviceValidator;
        $this->createDeviceUseCase = $createDeviceUseCase;
    }

    /**
     * @param CreateDeviceCommandInterface $createDeviceCommand
     */
    public function __invoke(CreateDeviceCommandInterface $createDeviceCommand): void
    {
        if (!$this->createDeviceValidator->validate($createDeviceCommand)) {
            throw new UnrecoverableMessageHandlingException(
                $this->createDeviceValidator->getFirstErrorMessage(),
                0
            );
        }

        try {
            /** @var DeviceInterface $device */
            $device = $this->createDeviceUseCase->create($createDeviceCommand);

            $this->deviceCommandRepository->create($device);
        } catch (Exception $exception) {
            $this->registry->resetManager();
            throw new UnrecoverableMessageHandlingException($exception->getMessage(), 0, $exception);
        }
    }
}
