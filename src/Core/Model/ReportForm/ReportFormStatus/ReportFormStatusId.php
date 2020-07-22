<?php

namespace App\Core\Model\ReportForm\ReportFormStatus;

use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\Exception\InvalidReportFormStatusIdException;
use App\Core\Model\ModelStringId;

class ReportFormStatusId extends ModelStringId
{
    /**
     * ReportFormStatusId constructor.
     * @param string $value
     * @throws InvalidReportFormStatusIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidReportFormStatusIdException('invalid ReportFormStatusId given');
        }
    }
}
