<?php

namespace App\App\Command\Item\PictureItem\Validator;

use App\App\Command\Item\BaseValidator\LabelValidator;
use App\App\Command\Item\BaseValidator\UpdateBaseItemValidator;
use App\App\Command\Item\PictureItem\UpdatePictureItemCommandInterface;

class UpdatePictureItemValidator extends BasePictureItemValidator implements UpdatePictureItemValidatorInterface
{
    /** @var UpdateBaseItemValidator */
    private $baseItemValidator;

    /**
     * UpdatePictureItemValidator constructor.
     * @param UpdateBaseItemValidator $baseItemValidator
     * @param LabelValidator $labelValidator
     */
    public function __construct(
        UpdateBaseItemValidator $baseItemValidator,
        LabelValidator $labelValidator
    ) {
        parent::__construct($labelValidator);

        $this->baseItemValidator = $baseItemValidator;
    }

    /**
     * @param UpdatePictureItemCommandInterface $command
     * @return bool
     */
    public function validate(UpdatePictureItemCommandInterface $command): bool
    {
        $this->baseItemValidator->validate($command);
        $this->validateByItemType($command);

        return true;
    }
}