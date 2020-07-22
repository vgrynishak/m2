<?php

namespace App\App\Command\Item\ListItem\Validator;

use App\App\Command\Item\BaseValidator\CreateBaseItemValidator;
use App\App\Command\Item\BaseValidator\LabelValidator;
use App\App\Command\Item\ListItem\CreateListItemCommandInterface;
use App\App\Doctrine\Repository\AnswerRepository;

class CreateListItemValidator extends BaseListItemValidator implements CreateListItemValidatorInterface
{
    /** @var CreateBaseItemValidator */
    private $baseItemValidator;

    /**
     * CreateListItemValidator constructor.
     * @param AnswerRepository $answerRepository
     * @param LabelValidator $labelValidator
     * @param CreateBaseItemValidator $baseItemValidator
     */
    public function __construct(
        AnswerRepository $answerRepository,
        LabelValidator $labelValidator,
        CreateBaseItemValidator $baseItemValidator
    ) {
        parent::__construct($answerRepository, $labelValidator);

        $this->baseItemValidator = $baseItemValidator;
    }

    /**
     * @inheritDoc
     */
    public function validate(CreateListItemCommandInterface $command): bool
    {
        $this->baseItemValidator->validate($command);
        $this->validateByItemType($command);

        return true;
    }
}
