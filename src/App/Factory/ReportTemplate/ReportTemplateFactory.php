<?php

namespace App\App\Factory\ReportTemplate;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidReportTemplateIdException;
use App\Core\Model\Exception\InvalidServiceIdException;
use App\Core\Model\ReportTemplate\ReportTemplate;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Model\Service\ServiceId;
use PhpCollection\Set;

class ReportTemplateFactory implements ReportTemplateFactoryInterface
{
    /**
     * @param string $id
     * @param string $name
     * @param string $serviceId
     * @param string $deviceId
     * @return ReportTemplateInterface
     * @throws InvalidDeviceIdException
     * @throws InvalidReportTemplateIdException
     * @throws InvalidServiceIdException
     */
    public function make(
        string $id,
        string $name,
        string $serviceId,
        string $deviceId
    ): ReportTemplateInterface {
        /** @var ReportTemplateInterface $reportTemplateModel */
        return new ReportTemplate(
            new ReportTemplateId($id),
            $name,
            new ServiceId($serviceId),
            new DeviceId($deviceId)
        );
    }

    /**
     * @param MessageInterface $command
     * @return ReportTemplateInterface
     */
    public function makeByCommand(MessageInterface $command): ReportTemplateInterface
    {
        /** @var ReportTemplateInterface $reportTemplate */
        $reportTemplate = new ReportTemplate(
            $command->getId(),
            $command->getName(),
            $command->getServiceId(),
            $command->getDeviceId()
        );

        $reportTemplate->setSections(new Set());

        return $reportTemplate;
    }
}
