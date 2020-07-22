<?php

namespace App\App\Command\Item\PickerItem\Validator;

use App\App\Command\Item\BaseValidator\LabelValidator;
use App\App\Command\Item\BaseValidator\UpdateBaseItemValidator;
use App\App\Command\Item\PickerItem\UpdatePickerItemCommandInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;

class UpdatePickerItemValidator extends BasePickerItemValidator implements UpdatePickerItemValidatorInterface
{
    /** @var UpdateBaseItemValidator */
    private $baseItemValidator;

    /**
     * UpdatePickerItemValidator constructor.
     * @param LabelValidator $labelValidator
     * @param ParagraphQueryRepositoryInterface $repository
     * @param UpdateBaseItemValidator $baseItemValidator
     */
    public function __construct(
        LabelValidator $labelValidator,
        ParagraphQueryRepositoryInterface $repository,
        UpdateBaseItemValidator $baseItemValidator
    ) {
        parent::__construct($labelValidator, $repository);

        $this->baseItemValidator = $baseItemValidator;
    }

    /**
     * @inheritDoc
     */
    public function validate(UpdatePickerItemCommandInterface $command): bool
    {
        $this->baseItemValidator->validate($command);

        $this->validateByItemType($command);

        return true;
    }
}
