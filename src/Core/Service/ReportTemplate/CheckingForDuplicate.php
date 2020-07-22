<?php

namespace App\Core\Service\ReportTemplate;

use App\Core\Model\ReportTemplate\ReportTemplateStatus;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;

class CheckingForDuplicate
{
    /** @var array */
    private static $statusesAvailable = [
        ReportTemplateStatus::DRAFT,
        ReportTemplateStatus::PUBLISHED,
        ReportTemplateStatus::ARCHIVED
    ];

    /**
     * @param ReportTemplateInterface $reportTemplate
     *
     * @return bool
     */
    public static function check(ReportTemplateInterface $reportTemplate)
    {
        /** @var ReportTemplateStatus $reportTemplateStatus */
        $reportTemplateStatus = $reportTemplate->getStatus();

        if (in_array($reportTemplateStatus->getId(), self::$statusesAvailable)) {
            return true;
        }

        return false;
    }
}
