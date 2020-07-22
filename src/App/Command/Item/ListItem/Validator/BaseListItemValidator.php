<?php

namespace App\App\Command\Item\ListItem\Validator;

use App\App\Command\Item\BaseItemCommandInterface;
use App\App\Command\Item\BaseValidator\LabelValidator;
use App\App\Command\Item\ListItem\CreateListItemCommand;
use App\App\Command\Item\ListItem\CreateListItemCommandInterface;
use App\App\Command\Item\ListItem\ListItemCommandInterface;
use App\App\Doctrine\Entity\Answer;
use App\App\Doctrine\Repository\AnswerRepository;
use App\Core\Model\Answer\AnswerAssessment\AnswerAssessment;
use App\Core\Model\Answer\AnswerInterface;
use App\Core\Model\Item\ItemType\ItemType;
use InvalidArgumentException;

abstract class BaseListItemValidator
{
    public const QUICK_SELECT_OPTION_COUNT = 3;
    public const SINGLE_SELECT_LIST_OPTION_MIN_COUNT = 2;
    public const MESSAGE_INVALID_QUICK_SELECT_OPTION_COUNT = 'The number of answers should be 3';
    public const MESSAGE_INVALID_SINGLE_SELECT_LIST_OPTION_COUNT = 'The number of answers should be more or equal 2';

    /** @var AnswerRepository */
    private $answerRepository;
    /** @var LabelValidator */
    private $labelValidator;

    public function __construct(AnswerRepository $answerRepository, LabelValidator $labelValidator)
    {
        $this->answerRepository = $answerRepository;
        $this->labelValidator = $labelValidator;
    }

    /**
     * @inheritDoc
     */
    public function validateByItemType(ListItemCommandInterface $command): void
    {
        $isCreate = $command instanceof CreateListItemCommand;

        $validateListCommonField = function ($errorCount, $errorMessage) use ($command, $isCreate) {
            $this->labelValidator->checkLabelLength($command->getLabel());

            $this->checkCountAnswers($command, $errorCount, $errorMessage);

            $this->checkAnswers($command, $isCreate);
        };

        /** @var CreateListItemCommandInterface $command */
        if ($command->getItemTypeId()->getValue() === ItemType::QUICK_SELECT) {
            $validateListCommonField(
                self::QUICK_SELECT_OPTION_COUNT,
                self::MESSAGE_INVALID_QUICK_SELECT_OPTION_COUNT
            );
        } elseif ($command->getItemTypeId()->getValue() === ItemType::SINGLE_SELECTION_LIST) {
            $validateListCommonField(
                self::SINGLE_SELECT_LIST_OPTION_MIN_COUNT,
                self::MESSAGE_INVALID_SINGLE_SELECT_LIST_OPTION_COUNT
            );
        } else {
            throw new InvalidArgumentException('Invalid itemType');
        }
    }

    /**
     * @param ListItemCommandInterface | BaseItemCommandInterface $command
     * @param int $count
     * @param string $errorMessage
     */
    private function checkCountAnswers(ListItemCommandInterface $command, int $count, string $errorMessage): void
    {
        $isQuickSelect = $command->getItemTypeId()->getValue() === ItemType::QUICK_SELECT;
        $answerCount = $command->getAnswers()->count();

        if ($isQuickSelect && $answerCount !== $count) {
            throw new InvalidArgumentException($errorMessage);
        }

        if (!$isQuickSelect && $answerCount < $count) {
            throw new InvalidArgumentException($errorMessage);
        }
    }

    private function checkAnswers(ListItemCommandInterface $command, bool $isCreate): void
    {
        $answers = $command->getAnswers();
        $defaultAnswerId = $command->getDefaultAnswer() ? $command->getDefaultAnswer()->getId()->getValue() : null;

        $answerIds = [];

        /** @var AnswerInterface $answer */
        foreach ($answers->getIterator() as $answer) {
            $answerId = $answer->getId()->getValue();

            $answerEntity = $this->answerRepository->find($answerId);

            if ($isCreate && ($answerEntity instanceof Answer || in_array($answerId, $answerIds, true))) {
                throw new InvalidArgumentException('Answer Id already exists');
            }
            $answerIds[] = $answerId;

            $answerLength = strlen(trim($answer->getValue()));
            if ($answerLength <= 0 || $answerLength > 255) {
                throw new InvalidArgumentException(
                    'Answer value must be >= 1 characters and <= 255 characters'
                );
            }

            if ($answerId === $defaultAnswerId && $answer->getAssessment()->getValue() === AnswerAssessment::NEGATIVE) {
                throw new InvalidArgumentException('DefaultAnswer Assessment can not be Negative');
            }
        }

        if ($defaultAnswerId && !in_array($defaultAnswerId, $answerIds, true)) {
            throw new InvalidArgumentException('DefaultAnswerId is not found In Answers');
        }
    }
}
