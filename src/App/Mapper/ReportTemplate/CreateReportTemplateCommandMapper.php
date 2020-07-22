<?php

namespace App\App\Mapper\ReportTemplate;

use App\App\Component\Message\MessageInterface;
use App\App\Factory\ReportTemplate\ReportTemplateFactoryInterface;
use App\Core\Model\ReportTemplate\ReportTemplate;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Model\ReportTemplate\ReportTemplateStatusInterface;
use App\Core\Model\ReportTemplate\ReportTemplateStatus;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateStatusQueryRepositoryInterface;
use App\Core\Repository\Service\ServiceQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class CreateReportTemplateCommandMapper implements CreateReportTemplateCommandMapperInterface
{
    /** @var ReportTemplateStatusQueryRepositoryInterface */
    private $reportTemplateStatusQueryRepository;
    /** @var ServiceQueryRepositoryInterface */
    private $serviceQueryRepository;
    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var ReportTemplateFactoryInterface */
    private $reportTemplateFactory;

    /**
     * CreateReportTemplateCommandMapper constructor.
     * @param ReportTemplateStatusQueryRepositoryInterface $reportTemplateStatusQueryRepository
     * @param ServiceQueryRepositoryInterface $serviceQueryRepository
     * @param DeviceQueryRepositoryInterface $deviceQueryRepository
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param ReportTemplateFactoryInterface $reportTemplateFactory
     */
    public function __construct(
        ReportTemplateStatusQueryRepositoryInterface $reportTemplateStatusQueryRepository,
        ServiceQueryRepositoryInterface $serviceQueryRepository,
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        UserQueryRepositoryInterface $userQueryRepository,
        ReportTemplateFactoryInterface $reportTemplateFactory
    ) {
        $this->reportTemplateStatusQueryRepository = $reportTemplateStatusQueryRepository;
        $this->serviceQueryRepository = $serviceQueryRepository;
        $this->deviceQueryRepository = $deviceQueryRepository;
        $this->userQueryRepository = $userQueryRepository;
        $this->reportTemplateFactory = $reportTemplateFactory;
    }

    /**
     * @param MessageInterface $command
     * @return ReportTemplateInterface
     */
    public function map(MessageInterface $command): ReportTemplateInterface
    {
        /** @var ReportTemplate $reportTemplate */
        $reportTemplate = $this->reportTemplateFactory->makeByCommand($command);

        if ($command->getDescription()) {
            $reportTemplate->setDescription($command->getDescription());
        }

        /** @var ReportTemplateStatusInterface $status */
        $status = $this->reportTemplateStatusQueryRepository->find(ReportTemplateStatus::DRAFT);
        $reportTemplate->setStatus($status);

        $reportTemplate->setCreatedAt($command->getCreatedAt());
        $reportTemplate->setUpdatedAt($command->getCreatedAt());
        $reportTemplate->setCreatedBy($command->getCreatedBy());
        $reportTemplate->setModifiedBy($command->getCreatedBy());

        return $reportTemplate;
    }
}
