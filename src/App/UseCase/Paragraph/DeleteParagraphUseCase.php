<?php

namespace App\App\UseCase\Paragraph;

use App\App\Command\Paragraph\DeleteParagraphCommandInterface;
use App\App\Doctrine\Entity\User as UserEntity;
use App\App\Doctrine\Repository\UserRepository;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Repository\Paragraph\ParagraphCommandRepositoryInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;
use App\Core\Service\Paragraph\ChangePositionInterface;

class DeleteParagraphUseCase implements DeleteParagraphUseCaseInterface
{
    /** @var ParagraphQueryRepositoryInterface */
    private $paragraphQueryRepository;
    /** @var ParagraphCommandRepositoryInterface */
    private $paragraphCommandRepository;
    /** @var UserRepository */
    private $userRepository;
    /** @var ChangePositionInterface */
    private $changePositionService;

    /**
     * DeleteParagraphUseCase constructor.
     * @param ParagraphQueryRepositoryInterface $paragraphQueryRepository
     * @param ParagraphCommandRepositoryInterface $paragraphCommandRepository
     * @param UserRepository $userRepository
     * @param ChangePositionInterface $changePositionService
     */
    public function __construct(
        ParagraphQueryRepositoryInterface $paragraphQueryRepository,
        ParagraphCommandRepositoryInterface $paragraphCommandRepository,
        UserRepository $userRepository,
        ChangePositionInterface $changePositionService
    ) {
        $this->paragraphQueryRepository = $paragraphQueryRepository;
        $this->paragraphCommandRepository = $paragraphCommandRepository;
        $this->userRepository = $userRepository;
        $this->changePositionService = $changePositionService;
    }

    /**
     * @param DeleteParagraphCommandInterface $command
     */
    public function delete(DeleteParagraphCommandInterface $command): void
    {
        /** @var BaseParagraphInterface $paragraph */
        $paragraph = $this->paragraphQueryRepository->find($command->getId());
        /** @var int $currentPosition */
        $currentPosition = $paragraph->getPosition();
        /** @var int $maxCurrentPosition */
        $maxCurrentPosition = $this->paragraphQueryRepository->getMaxPosition($paragraph);

        if ($currentPosition != $maxCurrentPosition) {
            /** @var UserEntity $userEntity */
            $userEntity = $this->userRepository->find($command->getModifiedBy()->getId());
            $this->changePositionService->decreaseParagraphListInPosition($paragraph, $maxCurrentPosition, $userEntity);
        }

        $this->paragraphCommandRepository->delete($paragraph);
    }
}
