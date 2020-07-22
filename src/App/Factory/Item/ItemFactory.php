<?php

namespace App\App\Factory\Item;

use App\App\Factory\Exception\FailMakeItemModel;
use App\Core\Model\Exception\InvalidItemCategoryIdException;
use App\Core\Model\Exception\InvalidItemTypeIdException;
use App\Core\Model\Item\PickerItem\FullDateItem;
use App\Core\Model\Item\InformationItem\DeviceInformationItem;
use App\Core\Model\Item\InputItem\CommentsWithDeficiencyItem;
use App\Core\Model\Item\InputItem\LongTextInputItem;
use App\Core\Model\Item\InputItem\NumericInputItem;
use App\Core\Model\Item\InputItem\ShortTextInputItem;
use App\Core\Model\Item\ItemId;
use App\Core\Model\Item\ItemInterface;
use App\Core\Model\Item\ItemType\ItemType;
use App\Core\Model\Item\ItemType\ItemTypeId;
use App\Core\Model\Item\ListItem\QuickSelectItem;
use App\Core\Model\Item\ListItem\SingleSelectListItem;
use App\Core\Model\Item\PickerItem\MonthYearDateItem;
use App\Core\Model\Item\PickerItem\SpecificTimeItem;
use App\Core\Model\Item\PickerItem\TimeIntervalItem;
use App\Core\Model\Item\PictureItem\PhotoItem;
use App\Core\Model\Item\PictureItem\SignatureItem;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Repository\Item\ItemType\ItemTypeQueryRepositoryInterface;

class ItemFactory implements ItemFactoryInterface
{
    /** @var ItemTypeQueryRepositoryInterface */
    private $itemTypeQueryRepository;

    public function __construct(ItemTypeQueryRepositoryInterface $itemTypeQueryRepository)
    {
        $this->itemTypeQueryRepository = $itemTypeQueryRepository;
    }

    /**
     * @param ItemId $id
     * @param ParagraphId $paragraphId
     * @param ItemTypeId $itemTypeId
     * @return ItemInterface
     * @throws FailMakeItemModel
     */
    public function make(ItemId $id, ParagraphId $paragraphId, ItemTypeId $itemTypeId): ItemInterface
    {
        try {
            $itemType = $this->itemTypeQueryRepository->find($itemTypeId);

            if ($itemTypeId->getValue() === ItemType::SHORT_TEXT_INPUT) {
                $item = new ShortTextInputItem($id, $paragraphId, $itemType);
            } elseif ($itemTypeId->getValue() === ItemType::LONG_TEXT_INPUT) {
                $item = new LongTextInputItem($id, $paragraphId, $itemType);
            } elseif ($itemTypeId->getValue() === ItemType::NUMERIC_INPUT) {
                $item = new NumericInputItem($id, $paragraphId, $itemType);
            } elseif ($itemTypeId->getValue() === ItemType::COMMENTS_WITH_DEFICIENCY) {
                $item = new CommentsWithDeficiencyItem($id, $paragraphId, $itemType);
            } elseif ($itemTypeId->getValue() === ItemType::QUICK_SELECT) {
                $item = new QuickSelectItem($id, $paragraphId, $itemType);
            } elseif ($itemTypeId->getValue() === ItemType::SINGLE_SELECTION_LIST) {
                $item = new SingleSelectListItem($id, $paragraphId, $itemType);
            } elseif ($itemTypeId->getValue() === ItemType::PHOTO) {
                $item = new PhotoItem($id, $paragraphId, $itemType);
            } elseif ($itemTypeId->getValue() === ItemType::SIGNATURE) {
                $item = new SignatureItem($id, $paragraphId, $itemType);
            } elseif ($itemTypeId->getValue() === ItemType::SPECIFIC_DATE) {
                $item = new FullDateItem($id, $paragraphId, $itemType);
            } elseif ($itemTypeId->getValue() === ItemType::MONTH_YEAR_DATE) {
                $item = new MonthYearDateItem($id, $paragraphId, $itemType);
            } elseif ($itemTypeId->getValue() === ItemType::SPECIFIC_TIME) {
                $item = new SpecificTimeItem($id, $paragraphId, $itemType);
            } elseif ($itemTypeId->getValue() === ItemType::TIME_INTERVAL) {
                $item = new TimeIntervalItem($id, $paragraphId, $itemType);
            } elseif ($itemTypeId->getValue() === ItemType::INFORMATION_DEVICE_RELATED) {
                $item = new DeviceInformationItem($id, $paragraphId, $itemType);
            } else {
                throw new InvalidItemTypeIdException('invalid item typeId');
            }

            return $item;
        } catch (InvalidItemCategoryIdException | InvalidItemTypeIdException $e) {
            throw  new FailMakeItemModel($e->getMessage());
        }
    }
}
