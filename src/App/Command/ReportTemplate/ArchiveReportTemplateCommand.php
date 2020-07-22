<?php

namespace App\App\Command\ReportTemplate;

use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\User\UserInterface;

class ArchiveReportTemplateCommand implements ArchiveReportTemplateCommandInterface
{
    /** @var ReportTemplateId */
    private $id;
    /** @var UserInterface */
    private $modifiedBy;

    /**
     * ArchiveReportTemplateCommand constructor.
     * @param ReportTemplateId $id
     * @param UserInterface $modifiedBy
     */
    public function __construct(ReportTemplateId $id, UserInterface $modifiedBy)
    {
        $this->id = $id;
        $this->modifiedBy = $modifiedBy;
    }

    /**
     * @return ReportTemplateId
     */
    public function getId(): ReportTemplateId
    {
        return $this->id;
    }

    /**
     * @return UserInterface
     */
    public function getModifiedBy(): UserInterface
    {
        return $this->modifiedBy;
    }
}
