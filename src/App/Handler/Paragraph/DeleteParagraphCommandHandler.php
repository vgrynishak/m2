<?php

namespace App\App\Handler\Paragraph;

use App\App\Command\Paragraph\DeleteParagraphCommandInterface;
use App\App\Command\Paragraph\Validator\DeleteParagraphValidatorInterface;
use App\App\UseCase\Paragraph\DeleteParagraphUseCaseInterface;
use App\Infrastructure\Exception\Paragraph\FailDeleteParagraphAction;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Exception;

class DeleteParagraphCommandHandler implements MessageHandlerInterface
{
    /** @var DeleteParagraphValidatorInterface */
    private $deleteParagraphValidator;
    /** @var DeleteParagraphUseCaseInterface */
    private $deleteParagraphUseCase;

    /**
     * DeleteParagraphCommandHandler constructor.
     * @param DeleteParagraphValidatorInterface $deleteParagraphValidator
     * @param DeleteParagraphUseCaseInterface $deleteParagraphUseCase
     */
    public function __construct(
        DeleteParagraphValidatorInterface $deleteParagraphValidator,
        DeleteParagraphUseCaseInterface $deleteParagraphUseCase
    ) {
        $this->deleteParagraphValidator = $deleteParagraphValidator;
        $this->deleteParagraphUseCase = $deleteParagraphUseCase;
    }

    /**
     * @param DeleteParagraphCommandInterface $command
     * @throws FailDeleteParagraphAction
     */
    public function __invoke(DeleteParagraphCommandInterface $command): void
    {
        if (!$this->deleteParagraphValidator->validate($command)) {
            throw new FailDeleteParagraphAction($this->deleteParagraphValidator->getFirstErrorMessage());
        }

        try {
            $this->deleteParagraphUseCase->delete($command);
        } catch (Exception $exception) {
            throw new FailDeleteParagraphAction("Bad request" . $exception->getMessage());
        }
    }
}
