<?php

namespace App\App\Query\ReportTemplate;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\ReportTemplate\ReportTemplateId;

class ReportTemplateQuery implements MessageInterface
{
    /** @var ReportTemplateId  */
    private $id;

    /**
     * ReportTemplateQuery constructor.
     * @param ReportTemplateId $id
     */
    public function __construct(ReportTemplateId $id)
    {
        $this->id = $id;
    }

    /**
     * @return ReportTemplateId
     */
    public function getId(): ReportTemplateId
    {
        return $this->id;
    }
}
