<?php

namespace App\Core\Service\Paragraph;

use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\ChildParagraphInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;

class LevelIterator implements LevelIteratorInterface
{
    /** @var ParagraphQueryRepositoryInterface */
    private $paragraphQueryRepository;
    /** @var int */
    private $currentPosition = 1;

    /**
     * LevelIterator constructor.
     * @param ParagraphQueryRepositoryInterface $paragraphQueryRepository
     */
    public function __construct(ParagraphQueryRepositoryInterface $paragraphQueryRepository)
    {
        $this->paragraphQueryRepository = $paragraphQueryRepository;
    }

    /**
     * @param $paragraph
     * @return int
     */
    public function next(BaseParagraphInterface $paragraph): int
    {
        if ($paragraph instanceof ChildParagraphInterface) {
            /** @var BaseParagraphInterface $parentParagraph */
            $parentParagraph = $this->paragraphQueryRepository->find($paragraph->getParent());

            if ($parentParagraph instanceof ChildParagraphInterface) {
                $this->currentPosition = $parentParagraph->getLevel();
            }
        }

        return ++$this->currentPosition;
    }
}
