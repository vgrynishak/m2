<?php

namespace App\App\Command\DeviceInstance\Validator;

use App\App\Command\DeviceInstance\CreateDeviceInstanceCommandInterface;
use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;
use App\Core\Model\Facility\FacilityInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\Core\Repository\DeviceInstance\DeviceInstanceQueryRepositoryInterface;
use App\Core\Repository\Facility\FacilityQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class CreateDeviceInstanceValidator extends BaseCommandValidator implements CreateDeviceInstanceValidatorInterface
{
    /** @var DeviceInstanceQueryRepositoryInterface */
    private $deviceInstanceQueryRepository;
    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;
    /** @var FacilityQueryRepositoryInterface */
    private $facilityQueryRepository;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * CreateDeviceInstanceValidator constructor.
     * @param DeviceInstanceQueryRepositoryInterface $deviceInstanceQueryRepository
     * @param DeviceQueryRepositoryInterface $deviceQueryRepository
     * @param FacilityQueryRepositoryInterface $facilityQueryRepository
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(
        DeviceInstanceQueryRepositoryInterface $deviceInstanceQueryRepository,
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        FacilityQueryRepositoryInterface $facilityQueryRepository,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->deviceInstanceQueryRepository = $deviceInstanceQueryRepository;
        $this->deviceQueryRepository = $deviceQueryRepository;
        $this->facilityQueryRepository = $facilityQueryRepository;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param CreateDeviceInstanceCommandInterface $command
     * @return bool
     */
    public function validate(CreateDeviceInstanceCommandInterface $command): bool
    {
        //TODO temporary solution for rabbit queue. Need to refactor
        $this->errors = [];
        /** @var DeviceInstanceInterface | null $deviceInstance */
        $deviceInstance = $this->deviceInstanceQueryRepository->find($command->getId());
        if ($deviceInstance instanceof DeviceInstanceInterface) {
            $this->errors[] = "DeviceInstance has already created";
        }

        /** @var DeviceInterface | null $device */
        $device = $this->deviceQueryRepository->find($command->getDeviceId());
        if (!$device instanceof DeviceInterface) {
            $this->errors[] = "Device was not found";
        }

        /** @var FacilityInterface $facility */
        $facility = $this->facilityQueryRepository->find($command->getFacilityId());
        if (!$facility instanceof FacilityInterface) {
            $this->errors[] = "Facility was not found";
        }

        /** @var UserInterface|null $user */
        $user = $this->userQueryRepository->find($command->getCreatedBy()->getId());
        if (!$user instanceof UserInterface) {
            $this->errors[] = "User was not found";
        }

        /** @var DeviceInstanceId | null $parentId */
        $parentId = $command->getParentId();
        if ($parentId instanceof DeviceInstanceId) {
            /** @var DeviceInstanceInterface | null $parent */
            $parent = $this->deviceInstanceQueryRepository->find($parentId);
            if (!$parent instanceof DeviceInstanceInterface) {
                $this->errors[] = "DeviceInstance parent was not found";
            }
        }

        return $this->check();
    }
}
