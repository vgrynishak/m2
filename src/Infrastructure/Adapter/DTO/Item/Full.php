<?php

namespace App\Infrastructure\Adapter\DTO\Item;

use App\Infrastructure\Adapter\DTO\Item\ItemType\ShortForItemCategory as ShortItemTypeDTO;
use App\Infrastructure\Adapter\DTO\Answer\Full as AnswerDTO;
use DateTime;

class Full
{
    /** @var string */
    private $id;
    /** @var string */
    private $paragraph;
    /** @var int */
    private $position;
    /** @var ShortItemTypeDTO */
    private $itemType;
    /** @var DateTime */
    private $createdAt;
    /** @var DateTime */
    private $updatedAt;
    /** @var bool */
    private $printable;
    /** @var string */
    private $label = null;
    /** @var string */
    private $NFPA = null;
    /** @var string */
    private $placeholder = null;
    /** @var string */
    private $remember = null;
    /** @var string */
    private $require = null;
    /** @var string */
    private $infoSource = null;
    /** @var AnswerDTO */
    private $defaultAnswer = null;
    /** @var array */
    private $options = null;

    /**
     * Full constructor.
     * @param string $id
     * @param string $paragraph
     * @param ShortItemTypeDTO $itemType
     */
    public function __construct(
        string $id,
        string $paragraph,
        ShortItemTypeDTO $itemType
    ) {
        $this->id = $id;
        $this->paragraph = $paragraph;
        $this->itemType = $itemType;
    }

    /**
     * @param int|null $position
     */
    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function setPrintable(?bool $printable): void
    {
        $this->printable = $printable;
    }

    public function setLabel(?string $label)
    {
        $this->label = $label;
    }

    public function setNFPA(?string $NFPA)
    {
        $this->NFPA = $NFPA;
    }

    public function setPlaceholder(?string $placeholder)
    {
        $this->placeholder = $placeholder;
    }

    public function setRemember(?string $remember)
    {
        $this->remember = $remember;
    }

    public function setRequire(?string $require)
    {
        $this->require = $require;
    }

    public function setInfoSource(?string $infoSource)
    {
        $this->infoSource = $infoSource;
    }

    public function setDefaultAnswer(AnswerDTO $defaultAnswer)
    {
        $this->defaultAnswer = $defaultAnswer;
    }

    public function setOptions(array $answers)
    {
        $this->options = $answers;
    }
}
