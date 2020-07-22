<?php

namespace App\App\Command\Item\InputItem\Validator;

use App\App\Command\Item\BaseValidator\LabelValidator;
use App\App\Command\Item\BaseValidator\UpdateBaseItemValidator;
use App\App\Command\Item\InputItem\UpdateInputItemCommandInterface;
use App\App\Doctrine\Repository\AnswerRepository;

class UpdateInputItemValidator extends BaseInputItemValidator implements UpdateInputItemValidatorInterface
{
    /** @var UpdateBaseItemValidator */
    private $baseItemValidator;


    public function __construct(
        UpdateBaseItemValidator $baseItemValidator,
        LabelValidator $labelValidator,
        AnswerRepository $answerRepository
    ) {
        parent::__construct($labelValidator, $answerRepository);

        $this->baseItemValidator = $baseItemValidator;
    }

    /**
     * @inheritDoc
     */
    public function validate(UpdateInputItemCommandInterface $command): bool
    {
        $this->baseItemValidator->validate($command);
        $this->validateByItemType($command);

        return true;
    }
}
