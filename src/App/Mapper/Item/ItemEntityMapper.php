<?php

namespace App\App\Mapper\Item;

use App\App\Doctrine\Entity\Item\Item as ItemEntity;
use App\App\Doctrine\Mapper\InfoSource\InfoSourceEntityToModelMapper;
use App\App\Doctrine\Repository\AnswerRepository;
use App\App\Factory\Item\ItemFactoryInterface;
use App\App\Mapper\Answer\AnswerEntityMapperInterface;
use App\Core\Model\Exception\InvalidDictionaryIdException;
use App\Core\Model\Exception\InvalidInfoSourceIdException;
use App\Core\Model\Item\Base\DefaultAnswerInterface;
use App\Core\Model\Item\Base\InfoSourceInterface;
use App\Core\Model\Item\Base\LabelInterface;
use App\Core\Model\Item\Base\NFPAInterface;
use App\Core\Model\Item\Base\OptionInterface;
use App\Core\Model\Item\Base\PlaceholderInterface;
use App\Core\Model\Item\Base\RememberInterface;
use App\Core\Model\Item\Base\RequireInterface;
use App\Core\Model\Item\ItemId;
use App\Core\Model\Item\ItemInterface;
use App\Core\Model\Item\ItemType\ItemTypeId;
use App\Core\Model\Paragraph\ParagraphId;
use App\App\Factory\Exception\FailMakeItemModel;
use App\Core\Model\Exception\InvalidItemIdException;
use App\Core\Model\Exception\InvalidItemTypeIdException;
use App\Core\Model\Exception\InvalidParagraphIdException;
use PhpCollection\CollectionInterface;
use PhpCollection\Set;

class ItemEntityMapper implements ItemEntityMapperInterface
{
    /** @var ItemFactoryInterface */
    private $itemFactory;

    /** @var AnswerEntityMapperInterface */
    private $answerEntityMapper;

    /** @var AnswerRepository */
    private $answerRepository;

    /** @var InfoSourceEntityToModelMapper */
    private $infoSourceEntityToModelMapper;

    /**
     * ItemEntityMapper constructor.
     * @param ItemFactoryInterface $itemFactory
     * @param AnswerEntityMapperInterface $answerEntityMapper
     * @param AnswerRepository $answerRepository
     * @param InfoSourceEntityToModelMapper $infoSourceEntityToModelMapper
     */
    public function __construct(
        ItemFactoryInterface $itemFactory,
        AnswerEntityMapperInterface $answerEntityMapper,
        AnswerRepository $answerRepository,
        InfoSourceEntityToModelMapper $infoSourceEntityToModelMapper
    ) {
        $this->itemFactory = $itemFactory;
        $this->answerEntityMapper = $answerEntityMapper;
        $this->answerRepository = $answerRepository;
        $this->infoSourceEntityToModelMapper = $infoSourceEntityToModelMapper;
    }

    /**
     * @param ItemEntity $itemORM
     * @return ItemInterface
     * @throws FailMakeItemModel
     * @throws InvalidItemIdException
     * @throws InvalidItemTypeIdException
     * @throws InvalidParagraphIdException
     * @throws InvalidDictionaryIdException
     * @throws InvalidInfoSourceIdException
     */
    public function map(ItemEntity $itemORM): ?ItemInterface
    {
        if (!$itemORM instanceof ItemEntity) {
            return null;
        }

        $item = $this->itemFactory->make(
            new ItemId($itemORM->getId()),
            new ParagraphId($itemORM->getParagraphId()->getId()),
            new ItemTypeId($itemORM->getItemTypeId()->getId())
        );

        $item->setPrintable($itemORM->getPrintable());
        $item->setPosition($itemORM->getPosition());
        $item->setCreatedAt($itemORM->getCreatedAt());
        $item->setUpdatedAt($itemORM->getUpdatedAt());

        if ($item instanceof LabelInterface) {
            $item->setLabel($itemORM->getLabel());
        }
        if ($item instanceof NFPAInterface) {
            $item->setNFPA($itemORM->getNFPAref());
        }
        if ($item instanceof PlaceholderInterface) {
            $item->setPlaceholder($itemORM->getPlaceholder());
        }
        if ($item instanceof RememberInterface) {
            $item->setRemember($itemORM->getRemembered());
        }
        if ($item instanceof RequireInterface) {
            $item->setRequire($itemORM->getRequired());
        }
        if ($item instanceof InfoSourceInterface) {
            $item->setInfoSource($this->infoSourceEntityToModelMapper->map($itemORM->getInfoSource()));
        }
        if ($item instanceof DefaultAnswerInterface) {
            $item->setDefaultAnswer($this->answerEntityMapper->map($itemORM->getDefaultAnswer()));
        }
        if ($item instanceof OptionInterface) {
            $item->setOptions($this->getAllOptionByItem($itemORM));
        }

        return $item;
    }

    private function getAllOptionByItem(ItemEntity $itemORM): CollectionInterface
    {
        $allAnswerEntity = $this->answerRepository->findByItemIdSortedByPosition($itemORM);

        $result = [];

        foreach ($allAnswerEntity as $answerORM) {
            $result[] = $this->answerEntityMapper->map($answerORM);
        }

        return new Set($result);
    }
}
