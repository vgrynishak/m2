<?php

namespace App\App\Command\Device\Validator;

use App\App\Command\Device\CreateDeviceCommandInterface;
use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Division\DivisionInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\Core\Repository\Division\DivisionQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class CreateDeviceValidator extends BaseCommandValidator implements CreateDeviceValidatorInterface
{
    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;
    /** @var DivisionQueryRepositoryInterface */
    private $divisionQueryRepository;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * CreateDeviceValidator constructor.
     * @param DeviceQueryRepositoryInterface $deviceQueryRepository
     * @param DivisionQueryRepositoryInterface $divisionQueryRepository
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        DivisionQueryRepositoryInterface $divisionQueryRepository,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->deviceQueryRepository = $deviceQueryRepository;
        $this->divisionQueryRepository = $divisionQueryRepository;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param CreateDeviceCommandInterface $command
     * @return bool
     */
    public function validate(CreateDeviceCommandInterface $command): bool
    {
        //TODO temporary solution for rabbit queue. Need to refactor
        $this->errors = [];

        /** @var DeviceInterface | null $device */
        $device = $this->deviceQueryRepository->find($command->getId());
        if ($device instanceof DeviceInterface) {
            $this->errors[] = "Device has already created";
        }

        /** @var UserInterface|null $user */
        $user = $this->userQueryRepository->find($command->getCreatedBy()->getId());
        if (!$user instanceof UserInterface) {
            $this->errors[] = "User was not found";
        }

        /** @var DivisionInterface | null $division */
        $division = $this->divisionQueryRepository->find($command->getDivisionId());
        if (!$division instanceof DivisionInterface) {
            $this->errors[] = "Division was not found";
        }

        /** @var DeviceId | null $parentId */
        $parentId = $command->getParentId();
        if ($parentId instanceof DeviceId) {
            /** @var DeviceInterface | null $parent */
            $parent = $this->deviceQueryRepository->find($parentId);
            if (!$parent instanceof DeviceInterface) {
                $this->errors[] = "Device parent was not found";
            }
        }

        if (strlen($command->getName()) < 3) {
            $this->errors[] = "Device`s name can not be less than 3";
        }

        if (strlen($command->getName()) > 256) {
            $this->errors[] = "Device`s name can not be more than 256";
        }

        if (strlen($command->getAlias()) < 3) {
            $this->errors[] = "Device`s alias can not be less than 3";
        }

        if (strlen($command->getAlias()) > 256) {
            $this->errors[] = "Device`s alias can not be more than 256";
        }

        if ($command->getLevel() > 3) {
            $this->errors[] = "Device`s level can not be more than 3";
        }

        return $this->check();
    }
}
