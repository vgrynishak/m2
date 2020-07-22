<?php

namespace App\Core\Repository\Section;

use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\Section\SectionId;
use App\Core\Model\Section\SectionInterface;
use PhpCollection\CollectionInterface;

interface SectionQueryRepositoryInterface
{
    public function find(SectionId $id): ?SectionInterface;

    public function getMaxPosition(ReportTemplateId $id): int;

    public function findListByReportTemplateVersionId(string $reportTemplateVersionId): ?CollectionInterface;
}
