<?php

namespace App\App\Handler\Paragraph;

use App\App\Command\Paragraph\EditParagraphCommandInterface;
use App\App\Command\Paragraph\Validator\EditParagraphValidatorInterface;
use App\App\UseCase\Paragraph\EditParagraphUseCaseInterface;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Repository\Paragraph\ParagraphCommandRepositoryInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;
use App\Infrastructure\Exception\Paragraph\FailEditAction;
use Exception;

class EditParagraphCommandHandler
{
    /** @var EditParagraphValidatorInterface */
    private $editParagraphValidator;

    /** @var ParagraphCommandRepositoryInterface */
    private $paragraphCommandRepository;

    /** @var ParagraphQueryRepositoryInterface */
    private $paragraphQueryRepository;

    /** @var EditParagraphUseCaseInterface */
    private $paragraphEditUseCase;

    /**
     * EditParagraphCommandHandler constructor.
     * @param EditParagraphValidatorInterface $editParagraphValidator
     * @param ParagraphCommandRepositoryInterface $paragraphCommandRepository
     * @param ParagraphQueryRepositoryInterface $paragraphQueryRepository
     * @param EditParagraphUseCaseInterface $paragraphEditUseCase
     */
    public function __construct(
        EditParagraphValidatorInterface $editParagraphValidator,
        ParagraphCommandRepositoryInterface $paragraphCommandRepository,
        ParagraphQueryRepositoryInterface $paragraphQueryRepository,
        EditParagraphUseCaseInterface $paragraphEditUseCase
    ) {
        $this->editParagraphValidator = $editParagraphValidator;
        $this->paragraphCommandRepository = $paragraphCommandRepository;
        $this->paragraphQueryRepository = $paragraphQueryRepository;
        $this->paragraphEditUseCase = $paragraphEditUseCase;
    }

    /**
     * @param EditParagraphCommandInterface $command
     * @throws FailEditAction
     */
    public function __invoke(EditParagraphCommandInterface $command)
    {
        if (!$this->editParagraphValidator->validate($command)) {
            throw new FailEditAction($this->editParagraphValidator->getFirstErrorMessage());
        }

        try {
            /** @var BaseParagraphInterface $paragraph */
            $paragraph = $this->paragraphEditUseCase->edit($command);

            $this->paragraphCommandRepository->update($paragraph);
        } catch (Exception $exception) {
            throw new FailEditAction($exception->getMessage());
        }
    }
}
