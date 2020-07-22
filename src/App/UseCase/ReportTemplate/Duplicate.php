<?php

namespace App\App\UseCase\ReportTemplate;

use App\App\Component\UUID\UUID;
use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\Exception\InvalidReportTemplateIdException;
use App\Core\Model\ReportTemplate\ReportTemplate;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Model\ReportTemplate\ReportTemplateStatus;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateStatusQueryRepositoryInterface;
use App\Infrastructure\Exception\ReportTemplate\FailDuplicateAction;
use App\Core\Service\ReportTemplate\CheckingForDuplicate;
use DateTime;

class Duplicate
{
    /** @var ReportTemplateStatusQueryRepositoryInterface */
    private $reportTemplateStatusQueryRepository;

    /**
     * Duplicate constructor.
     * @param ReportTemplateStatusQueryRepositoryInterface $reportTemplateStatusQueryRepository
     */
    public function __construct(ReportTemplateStatusQueryRepositoryInterface $reportTemplateStatusQueryRepository)
    {
        $this->reportTemplateStatusQueryRepository = $reportTemplateStatusQueryRepository;
    }

    /**
     * @param ReportTemplateInterface $reportTemplateModel
     * @param UserInterface $user
     * @return ReportTemplate
     * @throws FailDuplicateAction
     * @throws InvalidReportTemplateIdException
     */
    public function duplicate(ReportTemplateInterface $reportTemplateModel, UserInterface $user): ReportTemplate
    {
        if (!CheckingForDuplicate::check($reportTemplateModel)) {
            throw new FailDuplicateAction("Report template in unavailable status");
        }

        /** @var ReportTemplateStatus $statusDraft */
        $statusDraft = $this->reportTemplateStatusQueryRepository->find(ReportTemplateStatus::DRAFT);

        /** @var ReportTemplate $duplicatedReportTemplateModel */
        $duplicatedReportTemplateModel = clone $reportTemplateModel;
        /** @var UUID $newRtId */
        $newRtId = new UUID();
        $duplicatedReportTemplateModel->setId(new ReportTemplateId($newRtId->getValue()));
        $duplicatedReportTemplateModel->setStatus($statusDraft);
        $duplicatedReportTemplateModel->setCreatedAt(new DateTime());
        $duplicatedReportTemplateModel->setUpdatedAt(new DateTime());
        $duplicatedReportTemplateModel->setCreatedBy($user);
        $duplicatedReportTemplateModel->setModifiedBy($user);

        return $duplicatedReportTemplateModel;
    }
}
