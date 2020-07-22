<?php

namespace App\Core\Repository\Item;

use App\App\Factory\Exception\FailMakeItemModel;
use App\Core\Model\Exception\InvalidItemIdException;
use App\Core\Model\Exception\InvalidItemTypeIdException;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Item\ItemId;
use App\Core\Model\Item\ItemInterface;
use App\Core\Model\Paragraph\ParagraphId;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use PhpCollection\CollectionInterface;

interface ItemQueryRepositoryInterface
{
    /**
     * @param ParagraphId $paragraph
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getMaxPosition(ParagraphId $paragraph): int;

    /**
     * @param ParagraphId $paragraphId
     * @return CollectionInterface|null
     * @throws FailMakeItemModel
     * @throws InvalidItemIdException
     * @throws InvalidItemTypeIdException
     * @throws InvalidParagraphIdException
     */
    public function findListByParagraphId(ParagraphId $paragraphId): ?CollectionInterface;

    /**
     * @param ItemId $itemId
     * @return ItemInterface|null
     * @throws FailMakeItemModel
     * @throws InvalidItemIdException
     * @throws InvalidItemTypeIdException
     * @throws InvalidParagraphIdException
     */
    public function find(ItemId $itemId): ?ItemInterface;
}
