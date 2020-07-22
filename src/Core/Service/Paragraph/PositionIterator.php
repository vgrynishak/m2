<?php

namespace App\Core\Service\Paragraph;

use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\ChildParagraphWithDeviceInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\Paragraph\RootParagraphInterface;
use App\Core\Model\Section\SectionId;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;

class PositionIterator implements PositionIteratorInterface
{
    /** @var ParagraphQueryRepositoryInterface */
    private $paragraphQueryRepository;
    /** @var int  */
    private $currentPosition = 0;

    /**
     * PositionIterator constructor.
     * @param ParagraphQueryRepositoryInterface $paragraphQueryRepository
     */
    public function __construct(ParagraphQueryRepositoryInterface $paragraphQueryRepository)
    {
        $this->paragraphQueryRepository = $paragraphQueryRepository;
    }

    /**
     * @param BaseParagraphInterface $paragraph
     * @return int
     */
    public function next(BaseParagraphInterface $paragraph): int
    {
        if ($paragraph instanceof RootParagraphInterface) {

            /** @var SectionId $sectionId */
            $sectionId = $paragraph->getSectionId();

            $this->currentPosition = $this->paragraphQueryRepository->getMaxPositionForRoot($sectionId);
        }

        if ($paragraph instanceof ChildParagraphWithDeviceInterface) {

            /** @var ParagraphId $parentId */
            $parentId = $paragraph->getParent();

            $this->currentPosition = $this->paragraphQueryRepository->getMaxPositionForChild($parentId);
        }

        return ++$this->currentPosition;
    }
}
