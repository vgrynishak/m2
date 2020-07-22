<?php

namespace App\App\Factory\ReportTemplate;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;

interface ReportTemplateFactoryInterface
{
    /**
     * @param string $id
     * @param string $name
     * @param string $serviceId
     * @param string $deviceId
     * @return ReportTemplateInterface
     */
    public function make(
        string $id,
        string $name,
        string $serviceId,
        string $deviceId
    ): ReportTemplateInterface;

    /**
     * @param MessageInterface $command
     * @return ReportTemplateInterface
     */
    public function makeByCommand(MessageInterface $command): ReportTemplateInterface;
}
