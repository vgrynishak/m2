<?php

namespace App\App\Command\Item\ListItem\Validator;

use App\App\Command\Item\BaseValidator\LabelValidator;
use App\App\Command\Item\BaseValidator\UpdateBaseItemValidator;
use App\App\Command\Item\ListItem\UpdateListItemCommandInterface;
use App\App\Doctrine\Repository\AnswerRepository;

class UpdateListItemValidator extends BaseListItemValidator implements UpdateListItemValidatorInterface
{
    /** @var UpdateBaseItemValidator */
    private $baseItemValidator;

    /**
     * UpdateListItemValidator constructor.
     * @param AnswerRepository $answerRepository
     * @param LabelValidator $labelValidator
     * @param UpdateBaseItemValidator $baseItemValidator
     */
    public function __construct(
        AnswerRepository $answerRepository,
        LabelValidator $labelValidator,
        UpdateBaseItemValidator $baseItemValidator
    ) {
        parent::__construct($answerRepository, $labelValidator);

        $this->baseItemValidator = $baseItemValidator;
    }

    /**
     * @inheritDoc
     */
    public function validate(UpdateListItemCommandInterface $command): bool
    {
        $this->baseItemValidator->validate($command);
        $this->validateByItemType($command);

        return true;
    }
}
