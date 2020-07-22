<?php

namespace App\App\Command\Item\PickerItem\Validator;

use App\App\Command\Item\BaseItemCommandInterface;
use App\App\Command\Item\BaseValidator\LabelValidator;
use App\App\Command\Item\PickerItem\PickerItemCommandInterface;
use App\Core\Model\Item\ItemType\ItemType;
use App\Core\Model\Paragraph\WithDeviceParagraphInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;
use InvalidArgumentException;

abstract class BasePickerItemValidator
{
    /** @var LabelValidator */
    private $labelValidator;

    /** @var ParagraphQueryRepositoryInterface */
    private $repository;

    /**
     * BasePickerItemValidator constructor.
     * @param LabelValidator $labelValidator
     * @param ParagraphQueryRepositoryInterface $repository
     */
    public function __construct(LabelValidator $labelValidator, ParagraphQueryRepositoryInterface $repository)
    {
        $this->labelValidator = $labelValidator;
        $this->repository = $repository;
    }

    /**
     * @param PickerItemCommandInterface | BaseItemCommandInterface $command
     */
    public function validateByItemType(PickerItemCommandInterface $command): void
    {
        $validateInputCommonField = function () use ($command) {
            $this->labelValidator->checkLabelLength($command->getLabel());
            $this->checkRemember($command);
        };

        $itemTypeId = $command->getItemTypeId()->getValue();

        if ($itemTypeId === ItemType::SPECIFIC_TIME) {
            $validateInputCommonField();
        } elseif ($itemTypeId === ItemType::MONTH_YEAR_DATE) {
            $validateInputCommonField();
        } elseif ($itemTypeId === ItemType::SPECIFIC_DATE) {
            $validateInputCommonField();
        } elseif ($itemTypeId === ItemType::TIME_INTERVAL) {
            $validateInputCommonField();
        } else {
            throw new  InvalidArgumentException('Invalid itemType');
        }
    }

    /**
     * @param PickerItemCommandInterface | BaseItemCommandInterface$command
     * @throws InvalidArgumentException
     */
    private function checkRemember(PickerItemCommandInterface $command): void
    {
        $paragraph = $this->repository->find($command->getParagraphId());

        if (!$paragraph instanceof WithDeviceParagraphInterface && $command->getRemembered()) {
            throw new InvalidArgumentException('Remembered only in paragraphs linked to device');
        }
    }
}
