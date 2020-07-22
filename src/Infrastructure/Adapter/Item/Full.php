<?php

namespace App\Infrastructure\Adapter\Item;

use App\Core\Model\Item\Base\DefaultAnswerInterface;
use App\Core\Model\Item\Base\InfoSourceInterface;
use App\Core\Model\Item\Base\LabelInterface;
use App\Core\Model\Item\Base\NFPAInterface;
use App\Core\Model\Item\Base\OptionInterface;
use App\Core\Model\Item\Base\PlaceholderInterface;
use App\Core\Model\Item\Base\RememberInterface;
use App\Core\Model\Item\Base\RequireInterface;
use App\Core\Model\Item\ItemInterface;
use App\Infrastructure\Adapter\DTO\Item\ItemType\ShortForItemCategory as ItemType;
use PhpCollection\CollectionInterface;
use App\Infrastructure\Adapter\DTO\Item\Full as ItemDTO;
use App\Infrastructure\Adapter\Answer\Full as AnswerAdapter;

class Full
{
    public static function adapt(ItemInterface $item): ItemDTO
    {
        $itemDTO = new ItemDTO(
            $item->getId()->getValue(),
            $item->getParagraphId()->getValue(),
            new ItemType(
                $item->getItemType()->getId()->getValue(),
                $item->getItemType()->getName(),
                $item->getItemType()->getPosition()
            )
        )
        ;

        $itemDTO->setUpdatedAt($item->getUpdatedAt());
        $itemDTO->setCreatedAt($item->getCreatedAt());
        $itemDTO->setPrintable($item->getPrintable());
        $itemDTO->setPosition($item->getPosition());
        if ($item instanceof LabelInterface) {
            $itemDTO->setLabel($item->getLabel());
        }
        if ($item instanceof NFPAInterface) {
            $itemDTO->setNFPA($item->getNFPA());
        }
        if ($item instanceof PlaceholderInterface) {
            $itemDTO->setPlaceholder($item->getPlaceholder());
        }
        if ($item instanceof RememberInterface) {
            $itemDTO->setRemember($item->getRemember());
        }
        if ($item instanceof RequireInterface) {
            $itemDTO->setRequire($item->getRequire());
        }
        if ($item instanceof InfoSourceInterface) {
            $itemDTO->setInfoSource($item->getInfoSource());
        }
        if ($item instanceof DefaultAnswerInterface && $item->getDefaultAnswer()) {
            $itemDTO->setDefaultAnswer(AnswerAdapter::adapt($item->getDefaultAnswer()));
        }
        if ($item instanceof OptionInterface && $item->getOptions() && $item->getOptions()->count()) {
            $itemDTO->setOptions(AnswerAdapter::adaptCollection($item->getOptions()));
        }

        return $itemDTO;
    }

    /**
     * @param CollectionInterface $items
     * @return array
     */
    public static function adaptCollection(CollectionInterface $items): array
    {
        $result = [];

        /** @var ItemInterface $item */
        foreach ($items->getIterator() as $item) {
            $result[] =  self::adapt($item);
        }

        return $result;
    }
}
