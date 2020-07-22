<?php

namespace App\App\Command\ReportTemplate;

use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\User\UserInterface;

class EditReportTemplateCommand implements EditReportTemplateCommandInterface
{
    /** @var ReportTemplateId  */
    private $reportTemplateId;
    /** @var UserInterface */
    private $modifiedBy;
    /** @var string */
    private $name;
    /** @var string */
    private $description;

    /**
     * EditReportTemplateCommand constructor.
     * @param ReportTemplateId $reportTemplateId
     * @param UserInterface $modifiedBy
     * @param string $name
     */
    public function __construct(
        ReportTemplateId $reportTemplateId,
        UserInterface $modifiedBy,
        string $name
    ) {
        $this->reportTemplateId = $reportTemplateId;
        $this->modifiedBy = $modifiedBy;
        $this->name = $name;
    }

    /**
     * @return ReportTemplateId
     */
    public function getReportTemplateId(): ReportTemplateId
    {
        return $this->reportTemplateId;
    }

    /**
     * @return UserInterface
     */
    public function getModifiedBy(): UserInterface
    {
        return $this->modifiedBy;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
