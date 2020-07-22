<?php

namespace App\App\Command\Section;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;
use DateTime;

interface CreateSectionCommandInterface extends MessageInterface
{
    /**
     * @return SectionId
     */
    public function getId(): SectionId;

    /**
     * @return ReportTemplateId
     */
    public function getReportTemplateId(): ReportTemplateId;

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime;

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void;

    /**
     * @return UserInterface
     */
    public function getCreatedBy(): UserInterface;

    /**
     * @param UserInterface $createdBy
     */
    public function setCreatedBy(UserInterface $createdBy): void;
}
