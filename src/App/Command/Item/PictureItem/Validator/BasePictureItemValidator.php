<?php

namespace App\App\Command\Item\PictureItem\Validator;


use App\App\Command\Item\BaseValidator\LabelValidator;
use App\App\Command\Item\PictureItem\PictureItemCommandInterface;
use App\Core\Model\Item\ItemType\ItemType;
use InvalidArgumentException;

abstract class BasePictureItemValidator
{
    /** @var LabelValidator */
    private $labelValidator;

    public function __construct(LabelValidator $labelValidator)
    {
        $this->labelValidator = $labelValidator;
    }

    /**
     * @param PictureItemCommandInterface $command
     */
    public function validateByItemType(PictureItemCommandInterface $command): void
    {
        $itemTypeId = $command->getItemTypeId()->getValue();

        if ($itemTypeId === ItemType::PHOTO) {
            $this->checkPhotoItem($command);
        } elseif ($itemTypeId === ItemType::SIGNATURE) {
            $this->checkSignatureItem($command);
        } else {
            throw new  InvalidArgumentException('Invalid itemType');
        }
    }

    /**
     * @param PictureItemCommandInterface $command
     */
    private function checkPhotoItem(PictureItemCommandInterface $command)
    {
        $this->labelValidator->checkLabelLength($command->getLabel());
    }

    /**
     * @param PictureItemCommandInterface $command
     */
    private function checkSignatureItem(PictureItemCommandInterface $command)
    {
        $this->labelValidator->checkLabelLength($command->getLabel());

        if ($command->getRemembered()) {
            throw new  InvalidArgumentException('Signature Item cannot be remembered');
        }
    }
}