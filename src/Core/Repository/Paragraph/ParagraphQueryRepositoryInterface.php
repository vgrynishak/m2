<?php

namespace App\Core\Repository\Paragraph;

use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\Section\SectionId;
use PhpCollection\CollectionInterface;

interface ParagraphQueryRepositoryInterface
{
    /**
     * @param ParagraphId $id
     * @return BaseParagraphInterface|null
     */
    public function find(ParagraphId $id): ?BaseParagraphInterface;

    /**
     * @param SectionId $id
     * @return int
     */
    public function getMaxPositionForRoot(SectionId $id): int;

    /**
     * @param ParagraphId $parentId
     * @return CollectionInterface|null
     */
    public function findChildrenListByParentId(ParagraphId $parentId): ?CollectionInterface;

    /**
     * @param SectionId $sectionId
     * @return CollectionInterface|null
     */
    public function findListBySectionId(SectionId $sectionId): ?CollectionInterface;

    /**
     * @param ParagraphId $id
     * @return int
     */
    public function getMaxPositionForChild(ParagraphId $id): int;

    /**
     * @param BaseParagraphInterface $paragraph
     * @return int
     */
    public function getMaxPosition(BaseParagraphInterface $paragraph): int;
}
