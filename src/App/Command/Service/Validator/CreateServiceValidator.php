<?php

namespace App\App\Command\Service\Validator;

use App\App\Command\Service\CreateServiceCommandInterface;
use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Facility\FacilityInterface;
use App\Core\Model\Service\ServiceInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\Core\Repository\Facility\FacilityQueryRepositoryInterface;
use App\Core\Repository\Service\ServiceQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class CreateServiceValidator extends BaseCommandValidator implements CreateServiceValidatorInterface
{
    /** @var ServiceQueryRepositoryInterface */
    private $serviceQueryRepository;

    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;

    /** @var FacilityQueryRepositoryInterface */
    private $facilityQueryRepository;

    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * CreateServiceValidator constructor.
     * @param ServiceQueryRepositoryInterface $serviceQueryRepository
     * @param DeviceQueryRepositoryInterface $deviceQueryRepository
     * @param FacilityQueryRepositoryInterface $facilityQueryRepository
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(
        ServiceQueryRepositoryInterface $serviceQueryRepository,
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        FacilityQueryRepositoryInterface $facilityQueryRepository,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->serviceQueryRepository = $serviceQueryRepository;
        $this->deviceQueryRepository = $deviceQueryRepository;
        $this->facilityQueryRepository = $facilityQueryRepository;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param CreateServiceCommandInterface $command
     * @return bool
     */
    public function validate(CreateServiceCommandInterface $command): bool
    {
        /** @var ServiceInterface $service */
        $service = $this->serviceQueryRepository->find($command->getId());
        if ($service instanceof ServiceInterface) {
            $this->errors[] = 'Duplicate Service ID';
        }

        /** @var DeviceInterface $device */
        $device = $this->deviceQueryRepository->find($command->getDeviceId());
        if (!$device instanceof DeviceInterface) {
            $this->errors[] = 'Device was not found';
        }

        /** @var FacilityInterface $facility */
        $facility = $this->facilityQueryRepository->find($command->getFacilityId());
        if (!$facility instanceof FacilityInterface) {
            $this->errors[] = 'Facility was not found';
        }

        /** @var UserInterface $user */
        $user = $this->userQueryRepository->find($command->getCreatedBy()->getId());
        if (!$user instanceof UserInterface) {
            $this->errors[] = "User was not found";
        }

        if ($command->getModifiedBy()) {
            /** @var UserInterface $user */
            $user = $this->userQueryRepository->find($command->getModifiedBy()->getId());
            if (!$user instanceof UserInterface) {
                $this->errors[] = "User was not found";
            }
        }

        if (strlen($command->getName()) < 3) {
            $this->errors[] = "Service`s name cannot be less than 3";
        }

        if (strlen($command->getName()) > 256) {
            $this->errors[] = "Service`s name cannot be more than 256";
        }

        return $this->check();
    }
}
