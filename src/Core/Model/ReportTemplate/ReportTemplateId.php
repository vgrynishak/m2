<?php

namespace App\Core\Model\ReportTemplate;

use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\Exception\InvalidReportTemplateIdException;
use App\Core\Model\ModelId;

class ReportTemplateId extends ModelId
{
    /**
     * ReportTemplateId constructor.
     * @param string $value
     * @throws InvalidReportTemplateIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidReportTemplateIdException('Invalid ReportTemplateId given');
        }
    }
}
