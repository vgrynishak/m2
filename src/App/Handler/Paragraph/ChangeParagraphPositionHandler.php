<?php

namespace App\App\Handler\Paragraph;

use App\App\Command\Paragraph\ChangeParagraphPositionCommandInterface;
use App\App\Command\Paragraph\Validator\ChangeParagraphPositionValidatorInterface;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Repository\Paragraph\ParagraphCommandRepositoryInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;
use App\Infrastructure\Exception\Paragraph\FailChangeParagraphPositionAction;
use Exception;

class ChangeParagraphPositionHandler
{
    /** @var ChangeParagraphPositionValidatorInterface */
    private $changeParagraphPositionValidator;
    /** @var ParagraphQueryRepositoryInterface */
    private $paragraphQueryRepository;
    /** @var ParagraphCommandRepositoryInterface */
    private $paragraphCommandRepository;

    /**
     * ChangeParagraphPositionHandler constructor.
     * @param ChangeParagraphPositionValidatorInterface $changeParagraphPositionValidator
     * @param ParagraphQueryRepositoryInterface $paragraphQueryRepository
     * @param ParagraphCommandRepositoryInterface $paragraphCommandRepository
     */
    public function __construct(
        ChangeParagraphPositionValidatorInterface $changeParagraphPositionValidator,
        ParagraphQueryRepositoryInterface $paragraphQueryRepository,
        ParagraphCommandRepositoryInterface $paragraphCommandRepository
    ) {
        $this->changeParagraphPositionValidator = $changeParagraphPositionValidator;
        $this->paragraphQueryRepository = $paragraphQueryRepository;
        $this->paragraphCommandRepository = $paragraphCommandRepository;
    }

    /**
     * @param ChangeParagraphPositionCommandInterface $command
     * @throws FailChangeParagraphPositionAction
     */
    public function __invoke(ChangeParagraphPositionCommandInterface $command)
    {
        if (!$this->changeParagraphPositionValidator->validate($command)) {
            throw new FailChangeParagraphPositionAction(
                $this->changeParagraphPositionValidator->getFirstErrorMessage()
            );
        }

        try {
            /** @var BaseParagraphInterface $paragraph */
            $paragraph = $this->paragraphQueryRepository->find($command->getId());

            $this->paragraphCommandRepository->changePosition(
                $paragraph,
                $command->getNewPosition(),
                $command->getModifiedBy()->getId()
            );
        } catch (Exception $exception) {
            throw new FailChangeParagraphPositionAction($exception->getMessage());
        }
    }
}
