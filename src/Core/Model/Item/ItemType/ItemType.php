<?php

namespace App\Core\Model\Item\ItemType;

use App\Core\Model\Item\ItemCategory\ItemCategory;
use App\Core\Model\Item\ItemCategory\ItemCategoryId;

class ItemType implements ItemTypeInterface
{
    public const STATIC_TEXT = 'static_text';
    public const STATIC_KEY_VALUE = 'static_key_value';
    public const SUBTITLE = 'subtitle';
    public const SEPARATOR = 'separator';
    public const INFORMATION_DEVICE_RELATED = 'information_device_related';
    public const INFORMATION_FACILITY = 'information_facility';
    public const SHORT_TEXT_INPUT = 'short_text_input';
    public const NUMERIC_INPUT = 'numeric_input';
    public const LONG_TEXT_INPUT = 'long_text_input';
    public const QUICK_SELECT = 'quick_select';
    public const SINGLE_SELECTION_LIST = 'single_selection_list';
    public const SPECIFIC_DATE = 'specific_date';
    public const MONTH_YEAR_DATE = 'month_year_date';
    public const SPECIFIC_TIME = 'specific_time';
    public const TIME_INTERVAL = 'time_interval';
    public const PHOTO = 'photo';
    public const SIGNATURE = 'signature';
    public const COMMENTS_WITH_DEFICIENCY = 'comments_with_deficiency';
    public const PREFILLED_TEXT_INPUT = 'prefilled_text_input';

    /** @var ItemTypeId */
    private $id;
    /** @var ItemCategoryId */
    private $itemCategoryId;
    /** @var string */
    private $name;
    /** @var string */
    private $description;
    /** @var integer */
    private $position;

    /**
     * ItemType constructor.
     * @param ItemTypeId $id
     * @param ItemCategoryId $itemCategoryId
     * @param string $name
     */
    public function __construct(
        ItemTypeId $id,
        ItemCategoryId $itemCategoryId,
        string $name
    ) {
        $this->id = $id;
        $this->itemCategoryId = $itemCategoryId;
        $this->name = $name;
    }

    public function getId(): ItemTypeId
    {
        return $this->id;
    }

    /**
     * @return ItemCategoryId
     */
    public function getItemCategoryId(): ItemCategoryId
    {
        return $this->itemCategoryId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string | null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }
}
