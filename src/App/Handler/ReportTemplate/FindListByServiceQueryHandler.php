<?php

namespace App\App\Handler\ReportTemplate;

use App\App\Query\ReportTemplate\FindListByServiceQuery;
use App\Core\Repository\ReportTemplate\ReportTemplateQueryRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class FindListByServiceQueryHandler implements MessageHandlerInterface
{
    /** @var ReportTemplateQueryRepositoryInterface */
    protected $reportTemplateQueryRepositoryInterface;

    /**
     * FindListByServiceQueryHandler constructor.
     * @param ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepositoryInterface
     */
    public function __construct(ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepositoryInterface)
    {
        $this->reportTemplateQueryRepositoryInterface = $reportTemplateQueryRepositoryInterface;
    }

    /**
     * @param FindListByServiceQuery $findListByServiceQuery
     * @return mixed
     */
    public function __invoke(FindListByServiceQuery $findListByServiceQuery)
    {
        return $this->reportTemplateQueryRepositoryInterface->findListByServiceId(
            $findListByServiceQuery->getServiceId()
        );
    }
}
