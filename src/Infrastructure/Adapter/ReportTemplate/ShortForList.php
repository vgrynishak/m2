<?php

namespace App\Infrastructure\Adapter\ReportTemplate;

use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Infrastructure\Adapter\DTO\ReportTemplate\Short as ShortDTO;

class ShortForList
{
    /**
     * @param ReportTemplateInterface $reportTemplate
     *
     * @return ShortDTO
     */
    public static function adapt(ReportTemplateInterface $reportTemplate)
    {
        $username = $reportTemplate->getModifiedBy()->getEmail();
        $updatedAtTimestamp = $reportTemplate->getUpdatedAt()->getTimestamp();

        /** @var  $shortRt */
        $shortRt = new ShortDTO(
            $reportTemplate->getId()->getValue(),
            $reportTemplate->getName(),
            $updatedAtTimestamp,
            $username,
            $reportTemplate->getStatus()->getId()
        );
        $shortRt->setDescription($reportTemplate->getDescription());

        return $shortRt;
    }

    /**
     * @param array $list
     *
     * @return array
     */
    public static function adaptList(array $list)
    {
        $shortList = [];
        /** @var ReportTemplateInterface $item */
        foreach ($list as $item) {
            $shortList[] = self::adapt($item);
        }

        return ['resultGetListByService' => $shortList];
    }
}
