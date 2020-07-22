<?php

namespace App\App\Command\Item\PickerItem\Validator;

use App\App\Command\Item\BaseValidator\CreateBaseItemValidator;
use App\App\Command\Item\BaseValidator\LabelValidator;
use App\App\Command\Item\PickerItem\CreatePickerItemCommandInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;

class CreatePickerItemValidator extends BasePickerItemValidator implements CreatePickerItemValidatorInterface
{
    /** @var CreateBaseItemValidator */
    private $baseItemValidator;

    public function __construct(
        LabelValidator $labelValidator,
        ParagraphQueryRepositoryInterface $repository,
        CreateBaseItemValidator $baseItemValidator
    ) {
        parent::__construct($labelValidator, $repository);

        $this->baseItemValidator = $baseItemValidator;
    }

    /**
     * @inheritDoc
     */
    public function validate(CreatePickerItemCommandInterface $command): bool
    {
        $this->baseItemValidator->validate($command);

        $this->validateByItemType($command);

        return true;
    }
}
