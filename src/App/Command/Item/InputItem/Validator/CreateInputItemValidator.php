<?php

namespace App\App\Command\Item\InputItem\Validator;

use App\App\Command\Item\BaseValidator\CreateBaseItemValidator;
use App\App\Command\Item\BaseValidator\LabelValidator;
use App\App\Command\Item\InputItem\CreateInputItemCommandInterface;
use App\App\Doctrine\Repository\AnswerRepository;

class CreateInputItemValidator extends BaseInputItemValidator implements CreateInputItemValidatorInterface
{
    /** @var CreateBaseItemValidator */
    private $baseItemValidator;

    public function __construct(
        CreateBaseItemValidator $baseItemValidator,
        LabelValidator $labelValidator,
        AnswerRepository $answerRepository
    ) {
        parent::__construct($labelValidator, $answerRepository);

        $this->baseItemValidator = $baseItemValidator;
    }

    /**
     * @inheritDoc
     */
    public function validate(CreateInputItemCommandInterface $command): bool
    {
        $this->baseItemValidator->validate($command);
        $this->validateByItemType($command);

        return true;
    }
}
