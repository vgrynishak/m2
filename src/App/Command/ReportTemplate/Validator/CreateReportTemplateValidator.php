<?php

namespace App\App\Command\ReportTemplate\Validator;

use App\App\Command\ReportTemplate\CreateReportTemplateCommandInterface;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Model\Service\ServiceInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateQueryRepositoryInterface;
use App\Core\Repository\Service\ServiceQueryRepositoryInterface;
use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class CreateReportTemplateValidator extends BaseCommandValidator implements CreateReportTemplateValidatorInterface
{
    /** @var ServiceQueryRepositoryInterface */
    private $serviceQueryRepository;
    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;
    /** @var ReportTemplateQueryRepositoryInterface */
    private $reportTemplateQueryRepository;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * CreateReportTemplateValidator constructor.
     * @param ServiceQueryRepositoryInterface $serviceQueryRepository
     * @param DeviceQueryRepositoryInterface $deviceQueryRepository
     * @param ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(
        ServiceQueryRepositoryInterface $serviceQueryRepository,
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->serviceQueryRepository = $serviceQueryRepository;
        $this->deviceQueryRepository = $deviceQueryRepository;
        $this->reportTemplateQueryRepository = $reportTemplateQueryRepository;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param CreateReportTemplateCommandInterface $command
     * @return bool
     */
    public function validate(CreateReportTemplateCommandInterface $command): bool
    {
        /** @var ReportTemplateInterface $reportTemplate */
        $reportTemplate = $this->reportTemplateQueryRepository->find($command->getId());

        if ($reportTemplate instanceof ReportTemplateInterface) {
            $this->errors[] = "Report Template has already created";
        }

        /** @var ServiceInterface $service */
        $service = $this->serviceQueryRepository->find($command->getServiceId());
        if (!$service) {
            $this->errors[] = 'Invalid service';
        }

        /** @var DeviceInterface $device */
        $device = $this->deviceQueryRepository->find($command->getDeviceId());
        if (!$device) {
            $this->errors[] = 'Invalid device';
        }

        /** @var UserInterface $user */
        $user = $this->userQueryRepository->find($command->getCreatedBy()->getId());
        if (!$user instanceof UserInterface) {
            $this->errors[] = "User was not found";
        }

        if (strlen($command->getName()) < 3) {
            $this->errors[] = "Report Template`s name can not be less that 3";
        }

        if ($command->getDescription()) {
            if (strlen($command->getDescription()) < 3) {
                $this->errors[] = "Report Template`s description can not be less that 3";
            }
        }

        return $this->check();
    }
}
