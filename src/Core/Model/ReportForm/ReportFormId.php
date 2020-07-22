<?php

namespace App\Core\Model\ReportForm;

use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\Exception\InvalidReportFormIdException;
use App\Core\Model\ModelId;

class ReportFormId extends ModelId
{
    /**
     * ReportFormId constructor.
     * @param string $value
     * @throws InvalidReportFormIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidReportFormIdException('Invalid ReportFormId given');
        }
    }
}
