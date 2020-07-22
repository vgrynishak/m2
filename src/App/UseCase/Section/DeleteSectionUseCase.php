<?php

namespace App\App\UseCase\Section;

use App\App\Command\Section\DeleteSectionCommandInterface;
use App\App\Doctrine\Entity\User as UserEntity;
use App\App\Doctrine\Repository\UserRepository;
use App\Core\Model\Section\SectionInterface;
use App\Core\Repository\Section\SectionCommandRepositoryInterface;
use App\Core\Repository\Section\SectionQueryRepositoryInterface;
use App\Core\Service\Section\ChangePositionInterface;

class DeleteSectionUseCase implements DeleteSectionUseCaseInterface
{
    /** @var SectionQueryRepositoryInterface */
    private $sectionQueryRepository;
    /** @var UserRepository */
    private $userRepository;
    /** @var ChangePositionInterface */
    private $changePosition;
    /** @var SectionCommandRepositoryInterface */
    private $sectionCommandRepository;

    /**
     * DeleteSectionUseCase constructor.
     * @param SectionQueryRepositoryInterface $sectionQueryRepository
     * @param UserRepository $userRepository
     * @param ChangePositionInterface $changePosition
     * @param SectionCommandRepositoryInterface $sectionCommandRepository
     */
    public function __construct(
        SectionQueryRepositoryInterface $sectionQueryRepository,
        UserRepository $userRepository,
        ChangePositionInterface $changePosition,
        SectionCommandRepositoryInterface $sectionCommandRepository
    ) {
        $this->sectionQueryRepository = $sectionQueryRepository;
        $this->userRepository = $userRepository;
        $this->changePosition = $changePosition;
        $this->sectionCommandRepository = $sectionCommandRepository;
    }

    /**
     * @param DeleteSectionCommandInterface $command
     */
    public function delete(DeleteSectionCommandInterface $command): void
    {
        /** @var SectionInterface $section */
        $section = $this->sectionQueryRepository->find($command->getId());
        /** @var int $currentSectionPosition */
        $currentSectionPosition = $section->getPosition();
        /** @var int $maxCurrentPosition */
        $maxCurrentPosition = $this->sectionQueryRepository->getMaxPosition($section->getReportTemplateId());

        if ($currentSectionPosition != $maxCurrentPosition) {
            /** @var UserEntity $userEntity */
            $userEntity = $this->userRepository->find($command->getModifiedBy()->getId());
            $this->changePosition->decreaseSectionListInPosition($section, $maxCurrentPosition, $userEntity);
        }

        $this->sectionCommandRepository->delete($section);
    }
}
