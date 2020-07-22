<?php

namespace App\App\Command\Item\PictureItem\Validator;

use App\App\Command\Item\BaseValidator\CreateBaseItemValidator;
use App\App\Command\Item\BaseValidator\LabelValidator;
use App\App\Command\Item\PictureItem\CreatePictureItemCommandInterface;

class CreatePictureItemValidator extends BasePictureItemValidator implements CreatePictureItemValidatorInterface
{
    /** @var CreateBaseItemValidator */
    private $baseItemValidator;

    /**
     * CreatePictureItemValidator constructor.
     * @param CreateBaseItemValidator $baseItemValidator
     * @param LabelValidator $labelValidator
     */
    public function __construct(
        CreateBaseItemValidator $baseItemValidator,
        LabelValidator $labelValidator
    ) {
        parent::__construct($labelValidator);

        $this->baseItemValidator = $baseItemValidator;
    }

    /**
     * @param CreatePictureItemCommandInterface $command
     * @return bool
     */
    public function validate(CreatePictureItemCommandInterface $command): bool
    {
        $this->baseItemValidator->validate($command);
        $this->validateByItemType($command);

        return true;
    }
}