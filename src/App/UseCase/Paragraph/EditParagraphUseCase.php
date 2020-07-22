<?php

namespace App\App\UseCase\Paragraph;

use App\App\Command\Paragraph\EditParagraphCommandInterface;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;
use DateTime;
use Exception;

class EditParagraphUseCase implements EditParagraphUseCaseInterface
{
    /** @var ParagraphQueryRepositoryInterface */
    private $paragraphQueryRepository;

    /**
     * EditParagraphUseCase constructor.
     * @param ParagraphQueryRepositoryInterface $paragraphQueryRepository
     */
    public function __construct(ParagraphQueryRepositoryInterface $paragraphQueryRepository)
    {
        $this->paragraphQueryRepository = $paragraphQueryRepository;
    }

    /**
     * @param EditParagraphCommandInterface $command
     * @return BaseParagraphInterface
     * @throws Exception
     */
    public function edit(EditParagraphCommandInterface $command): BaseParagraphInterface
    {
        /** @var BaseParagraphInterface $paragraph */
        $paragraph = $this->paragraphQueryRepository->find($command->getId());

        $paragraph->setHeader($command->getHeader());
        $paragraph->setUpdatedAt(new DateTime());
        $paragraph->setModifiedBy($command->getModifiedBy());

        return $paragraph;
    }
}
