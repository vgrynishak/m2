<?php

namespace App\Infrastructure\Parser\ReportTemplate;

use App\App\Command\ReportTemplate\GetByIdCommand;
use App\App\Command\ReportTemplate\GetByIdCommandInterface;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class GetByIdParser implements GetByIdParserInterface
{
    /**
     * @param Request $request
     * @return GetByIdCommandInterface
     */
    public function parse(Request $request) : GetByIdCommandInterface
    {
        /** @var ReportTemplateId $reportTemplateId */
        $reportTemplateId = $request->get('reportTemplateId');

        if (!$reportTemplateId instanceof ReportTemplateId) {
            throw new InvalidArgumentException('Report Template Id is required field');
        }

        return new GetByIdCommand($reportTemplateId);
    }
}
