<?php

namespace App\App\Handler\Section;

use App\App\Command\Section\DeleteSectionCommandInterface;
use App\App\Command\Section\Validator\DeleteSectionValidatorInterface;
use App\App\UseCase\Section\DeleteSectionUseCaseInterface;
use App\Infrastructure\Exception\Section\FailDeleteSectionAction;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Exception;

class DeleteSectionHandler implements MessageHandlerInterface
{
    /** @var DeleteSectionValidatorInterface */
    private $deleteSectionValidator;
    /** @var DeleteSectionUseCaseInterface */
    private $deleteSectionUseCase;

    /**
     * DeleteSectionHandler constructor.
     * @param DeleteSectionValidatorInterface $deleteSectionValidator
     * @param DeleteSectionUseCaseInterface $deleteSectionUseCase
     */
    public function __construct(
        DeleteSectionValidatorInterface $deleteSectionValidator,
        DeleteSectionUseCaseInterface $deleteSectionUseCase
    ) {
        $this->deleteSectionValidator = $deleteSectionValidator;
        $this->deleteSectionUseCase = $deleteSectionUseCase;
    }

    /**
     * @param DeleteSectionCommandInterface $command
     * @throws FailDeleteSectionAction
     */
    public function __invoke(DeleteSectionCommandInterface $command): void
    {
        if (!$this->deleteSectionValidator->validate($command)) {
            throw new FailDeleteSectionAction($this->deleteSectionValidator->getFirstErrorMessage());
        }

        try {
            $this->deleteSectionUseCase->delete($command);
        } catch (Exception $exception) {
            throw new FailDeleteSectionAction("Bad request");
        }
    }
}
