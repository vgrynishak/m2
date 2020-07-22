<?php

namespace App\Infrastructure\Parser\ReportTemplate;

use Symfony\Component\HttpFoundation\Request;
use App\App\Query\ReportTemplate\FindListByServiceQuery;
use App\Core\Model\Service\ServiceId;
use App\Infrastructure\Exception\ReportTemplate\FailGetListAction;
use App\Infrastructure\Parser\ParserInterface;
use Exception;

class GetListByServiceId implements ParserInterface
{
    /**
     * @param Request $request
     *
     * @return FindListByServiceQuery
     * @throws FailGetListAction
     */
    public function parse(Request $request): FindListByServiceQuery
    {
        try {
            /** @var ServiceId $serviceId */
            $serviceId = $request->get('serviceId');

            return new FindListByServiceQuery($serviceId);
        } catch (Exception $exception) {
            throw new FailGetListAction("Bad request");
        }
    }
}
