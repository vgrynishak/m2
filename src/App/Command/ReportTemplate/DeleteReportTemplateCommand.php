<?php

namespace App\App\Command\ReportTemplate;

use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\User\UserInterface;

class DeleteReportTemplateCommand implements DeleteReportTemplateCommandInterface
{
    /** @var ReportTemplateId  */
    private $id;
    /** @var UserInterface */
    private $user;

    /**
     * DeleteReportTemplateCommand constructor.
     * @param ReportTemplateId $id
     * @param UserInterface $user
     */
    public function __construct(ReportTemplateId $id, UserInterface $user)
    {
        $this->id = $id;
        $this->user = $user;
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
    public function getUser(): UserInterface
    {
        return $this->user;
    }
}
