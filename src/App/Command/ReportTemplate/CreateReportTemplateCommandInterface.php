<?php

namespace App\App\Command\ReportTemplate;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\User\User;
use App\Core\Model\User\UserInterface;
use DateTime;

interface CreateReportTemplateCommandInterface extends MessageInterface
{
    /**
     * @return ReportTemplateId
     */
    public function getId(): ReportTemplateId;

    /**
     * @return DeviceId
     */
    public function getDeviceId(): DeviceId;

    /**
     * @return ServiceId
     */
    public function getServiceId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return DateTime
     */
    public function getCreatedAt();

    /**
     * @return User
     */
    public function getCreatedBy(): UserInterface;

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void;

    /**
     * @param UserInterface $createdBy
     */
    public function setCreatedBy(UserInterface $createdBy): void;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void;
}
