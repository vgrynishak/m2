<?php

namespace App\Core\Service\Section;

use App\App\Doctrine\Entity\Section as SectionEntity;
use App\App\Doctrine\Entity\User as UserEntity;
use App\App\Doctrine\Repository\SectionRepository;
use App\Core\Model\Section\SectionInterface;
use DateTime;
use Exception;

class ChangePosition implements ChangePositionInterface
{
    /** @var SectionRepository */
    private $sectionRepository;

    /**
     * ChangePosition constructor.
     * @param SectionRepository $sectionRepository
     */
    public function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    /**
     * @param SectionInterface $section
     * @param int $positionToChange
     * @param UserEntity $user
     * @throws Exception
     */
    public function increaseSectionListInPosition(
        SectionInterface $section,
        int $positionToChange,
        UserEntity $user
    ): void {
        /** @var SectionEntity[] $sectionsEntity */
        $sectionsEntity = $this->sectionRepository->getListWhoNeedIncreaseInPosition($section, $positionToChange);
        /** @var SectionEntity $sectionEntity */
        foreach ($sectionsEntity as $sectionEntity) {
            /** @var int $resultPosition */
            $resultPosition = $sectionEntity->getPosition() + 1;
            $this->changeBaseFields($sectionEntity, $resultPosition, $user);
        }
    }

    /**
     * @param SectionInterface $section
     * @param int $positionToChange
     * @param UserEntity $user
     * @throws Exception
     */
    public function decreaseSectionListInPosition(
        SectionInterface $section,
        int $positionToChange,
        UserEntity $user
    ): void {
        /** @var SectionEntity[] $sectionsEntity */
        $sectionsEntity = $this->sectionRepository->getListWhoNeedDecreaseInPosition($section, $positionToChange);
        /** @var SectionEntity $sectionEntity */
        foreach ($sectionsEntity as $sectionEntity) {
            /** @var int $resultPosition */
            $resultPosition = $sectionEntity->getPosition() - 1;
            $this->changeBaseFields($sectionEntity, $resultPosition, $user);
        }
    }

    /**
     * @param SectionEntity $sectionEntity
     * @param int $resultPosition
     * @param UserEntity $user
     * @throws Exception
     */
    public function changeBaseFields(SectionEntity $sectionEntity, int $resultPosition, UserEntity $user): void
    {
        $sectionEntity->setPosition($resultPosition);
        $sectionEntity->setModifiedBy($user);
        $sectionEntity->setUpdatedAt(new DateTime());
    }
}
