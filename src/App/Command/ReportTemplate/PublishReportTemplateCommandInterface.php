<?php

namespace App\App\Command\ReportTemplate;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\User\UserInterface;

interface PublishReportTemplateCommandInterface extends MessageInterface
{
    /**
     * @return ReportTemplateId
     */
    public function getId(): ReportTemplateId;

    /**
     * @return UserInterface
     */
    public function getUser() : UserInterface;
}
