<?php

namespace App\App\Command\Item\InputItem\Validator;

use App\App\Command\Item\BaseValidator\LabelValidator;
use App\App\Command\Item\InputItem\CreateInputItemCommand;
use App\App\Command\Item\InputItem\InputItemCommandInterface;
use App\App\Doctrine\Entity\Answer;
use App\App\Doctrine\Repository\AnswerRepository;
use App\Core\Model\Answer\AnswerAssessment\AnswerAssessment;
use App\Core\Model\Item\ItemType\ItemType;
use InvalidArgumentException;

abstract class BaseInputItemValidator
{
    public const SHORT_TEXT_MAX_LENGTH_ANSWER = 255;
    public const LONG_TEXT_MAX_LENGTH_ANSWER = 5000;
    public const NUMERIC_MAX_LENGTH_ANSWER = 255;
    public const COMMENTS_WITH_DEFICIENCY_MAX_LENGTH_ANSWER = 5000;

    /** @var LabelValidator */
    private $labelValidator;

    /** @var AnswerRepository */
    private $answerRepository;

    /**
     * BaseInputItemValidator constructor.
     * @param LabelValidator $labelValidator
     * @param AnswerRepository $answerRepository
     */
    public function __construct(
        LabelValidator $labelValidator,
        AnswerRepository $answerRepository
    ) {
        $this->labelValidator = $labelValidator;
        $this->answerRepository = $answerRepository;
    }

    /**
     * @param InputItemCommandInterface $command
     */
    public function validateByItemType(InputItemCommandInterface $command): void
    {
        $isCreate = $command instanceof CreateInputItemCommand;

        $validateInputCommonField = function ($maxLength, $isNumber = false) use ($command, $isCreate) {
            $this->labelValidator->checkLabelLength($command->getLabel());
            $this->checkDefaultAnswer($command, $maxLength, $isCreate, $isNumber);
        };

        $itemTypeId = $command->getItemTypeId()->getValue();

        if ($itemTypeId === ItemType::SHORT_TEXT_INPUT) {
            $validateInputCommonField(self::SHORT_TEXT_MAX_LENGTH_ANSWER);
        } elseif ($itemTypeId === ItemType::LONG_TEXT_INPUT) {
            $validateInputCommonField(self::LONG_TEXT_MAX_LENGTH_ANSWER);
        } elseif ($itemTypeId === ItemType::NUMERIC_INPUT) {
            $validateInputCommonField(self::NUMERIC_MAX_LENGTH_ANSWER, true);
        } elseif ($itemTypeId === ItemType::COMMENTS_WITH_DEFICIENCY) {
            $validateInputCommonField(self::COMMENTS_WITH_DEFICIENCY_MAX_LENGTH_ANSWER);
        } else {
            throw new  InvalidArgumentException('Invalid itemType');
        }
    }

    /**
     * @param InputItemCommandInterface $command
     * @param int $maxLength
     * @param bool $isNumber
     * @param bool $isCreate
     */
    private function checkDefaultAnswer(
        InputItemCommandInterface $command,
        int $maxLength,
        bool $isCreate,
        $isNumber = false
    ): void {
        if ($defaultAnswer = $command->getDefaultAnswer()) {
            $answerEntity = $this->answerRepository->find($defaultAnswer->getId()->getValue());

            if ($isCreate && $answerEntity instanceof Answer) {
                throw new InvalidArgumentException('Answer Id already exists');
            }

            $answerLength = strlen(trim($defaultAnswer->getValue()));
            if ($answerLength <= 0 || $answerLength > $maxLength) {
                throw new InvalidArgumentException(
                    'DefaultAnswer value must be >= 1 characters and <= '.$maxLength.' characters'
                );
            }
            if ($defaultAnswer->getAssessment()->getValue() === AnswerAssessment::NEGATIVE) {
                throw new InvalidArgumentException('DefaultAnswer Assessment can not be Negative');
            }

            if ($isNumber && !is_numeric($defaultAnswer->getValue())) {
                throw new InvalidArgumentException('DefaultAnswer value should be numeric');
            }
        }
    }
}
