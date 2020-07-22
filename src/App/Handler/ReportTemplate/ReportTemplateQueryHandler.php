<?php

namespace App\App\Handler\ReportTemplate;

use App\Core\Model\ReportTemplate\ReportTemplate;
use App\App\Query\ReportTemplate\ReportTemplateQuery;
use App\Core\Repository\ReportTemplate\ReportTemplateQueryRepositoryInterface;

class ReportTemplateQueryHandler
{
    /** @var ReportTemplateQueryRepositoryInterface  */
    protected $repository;

    /**
     * ReportTemplateQueryHandler constructor.
     * @param ReportTemplateQueryRepositoryInterface $repository
     */
    public function __construct(ReportTemplateQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ReportTemplateQuery $query
     * @return ReportTemplate
     */
    public function __invoke(ReportTemplateQuery $query)
    {
        return $this->repository->find($query->getId());
    }
}
