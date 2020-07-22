<?php

namespace App\Core\Service\Section;

use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Repository\Section\SectionQueryRepositoryInterface;

class PositionIterator implements PositionIteratorInterface
{
    /** @var SectionQueryRepositoryInterface */
    private $sectionQueryRepository;

    /**
     * PositionIterator constructor.
     * @param SectionQueryRepositoryInterface $sectionQueryRepository
     */
    public function __construct(SectionQueryRepositoryInterface $sectionQueryRepository)
    {
        $this->sectionQueryRepository = $sectionQueryRepository;
    }

    /**
     * @param ReportTemplateId $reportTemplateId
     * @return int
     */
    public function next(ReportTemplateId $reportTemplateId): int
    {
        /** @var int $currentPosition */
        $currentPosition = $this->sectionQueryRepository->getMaxPosition($reportTemplateId);

        return ++$currentPosition;
    }
}
