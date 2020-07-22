<?php

namespace App\Core\Service\Item;

use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Repository\Item\ItemQueryRepositoryInterface;
use App\Core\Repository\Section\SectionQueryRepositoryInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class PositionIterator implements PositionIteratorInterface
{
    /** @var ItemQueryRepositoryInterface */
    private $itemQueryRepository;

    /**
     * PositionIterator constructor.
     * @param SectionQueryRepositoryInterface $sectionQueryRepository
     */
    public function __construct(ItemQueryRepositoryInterface $itemQueryRepository)
    {
        $this->itemQueryRepository = $itemQueryRepository;
    }

    /**
     * @param ParagraphId $paragraph
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function next(ParagraphId $paragraph): int
    {
        /** @var int $currentPosition */
        $currentPosition = $this->itemQueryRepository->getMaxPosition($paragraph);

        return ++$currentPosition;
    }
}