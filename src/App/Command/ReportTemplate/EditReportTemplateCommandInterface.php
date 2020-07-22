<?php

namespace App\App\Command\ReportTemplate;

use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\User\UserInterface;
use App\App\Component\Message\MessageInterface;

interface EditReportTemplateCommandInterface extends MessageInterface
{
    /**
     * @return ReportTemplateId
     */
    public function getReportTemplateId(): ReportTemplateId;

    /**
     * @return UserInterface
     */
    public function getModifiedBy(): UserInterface;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void;
}
