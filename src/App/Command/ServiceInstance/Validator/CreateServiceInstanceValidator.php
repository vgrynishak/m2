<?php

namespace App\App\Command\ServiceInstance\Validator;

use App\App\Command\ServiceInstance\CreateServiceInstanceCommandInterface;
use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\Core\Model\Facility\FacilityInterface;
use App\Core\Model\Service\ServiceInterface;
use App\Core\Model\ServiceInstance\ServiceInstanceInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Facility\FacilityQueryRepositoryInterface;
use App\Core\Repository\Service\ServiceQueryRepositoryInterface;
use App\Core\Repository\ServiceInstance\ServiceInstanceQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class CreateServiceInstanceValidator extends BaseCommandValidator implements CreateServiceInstanceValidatorInterface
{
    /** @var ServiceInstanceQueryRepositoryInterface */
    private $serviceInstanceQueryRepository;
    /** @var ServiceQueryRepositoryInterface */
    private $serviceQueryRepository;
    /** @var FacilityQueryRepositoryInterface */
    private $facilityQueryRepository;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * CreateServiceInstanceValidator constructor.
     * @param ServiceInstanceQueryRepositoryInterface $serviceInstanceQueryRepository
     * @param ServiceQueryRepositoryInterface $serviceQueryRepository
     * @param FacilityQueryRepositoryInterface $facilityQueryRepository
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(
        ServiceInstanceQueryRepositoryInterface $serviceInstanceQueryRepository,
        ServiceQueryRepositoryInterface $serviceQueryRepository,
        FacilityQueryRepositoryInterface $facilityQueryRepository,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->serviceInstanceQueryRepository = $serviceInstanceQueryRepository;
        $this->serviceQueryRepository = $serviceQueryRepository;
        $this->facilityQueryRepository = $facilityQueryRepository;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param CreateServiceInstanceCommandInterface $command
     * @return bool
     */
    public function validate(CreateServiceInstanceCommandInterface $command): bool
    {
        //TODO temporary solution for rabbit queue. Need to refactor
        $this->errors = [];
        /** @var ServiceInstanceInterface | null $serviceInstance */
        $serviceInstance = $this->serviceInstanceQueryRepository->find($command->getId());
        if ($serviceInstance instanceof ServiceInstanceInterface) {
            $this->errors[] = "ServiceInstance has already created";
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

        /** @var ServiceInterface | null $service */
        $service = $this->serviceQueryRepository->find($command->getServiceId());
        if (!$service instanceof ServiceInterface) {
            $this->errors[] = "Service was not found";
        }

        return $this->check();
    }
}
