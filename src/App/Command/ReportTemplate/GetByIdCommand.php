<?php

namespace App\App\Command\ReportTemplate;

use App\Core\Model\ReportTemplate\ReportTemplateId;

class GetByIdCommand implements GetByIdCommandInterface
{
    /** @var ReportTemplateId */
    private $id;

    /**
     * GetByIdCommand constructor.
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
