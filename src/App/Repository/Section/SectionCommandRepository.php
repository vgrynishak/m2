<?php

namespace App\App\Repository\Section;

use App\App\Doctrine\Entity\Section;
use App\App\Doctrine\Entity\Section as SectionEntity;
use App\App\Doctrine\Entity\User as UserEntity;
use App\App\Doctrine\Repository\UserRepository;
use App\App\Mapper\Exception\EntityNotFound;
use App\Core\Model\Section\SectionInterface;
use App\Core\Repository\Section\SectionCommandRepositoryInterface;
use App\Core\Service\Section\ChangePositionInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use App\App\Doctrine\Mapper\Section\SectionModelInterface as SectionModelToEntityMapperInterface;
use Exception;

class SectionCommandRepository implements SectionCommandRepositoryInterface
{
    /** @var EntityManagerInterface  */
    protected $entityManager;
    /** @var SectionModelToEntityMapperInterface */
    private $sectionModelToEntityMapper;
    /** @var UserRepository */
    private $userRepository;
    /** @var ChangePositionInterface */
    private $changeSectionPositionService;

    /**
     * SectionCommandRepository constructor.
     * @param EntityManagerInterface $entityManager
     * @param SectionModelToEntityMapperInterface $sectionModelToEntityMapper
     * @param UserRepository $userRepository
     * @param ChangePositionInterface $changeSectionPositionService
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        SectionModelToEntityMapperInterface $sectionModelToEntityMapper,
        UserRepository $userRepository,
        ChangePositionInterface $changeSectionPositionService
    ) {
        $this->entityManager = $entityManager;
        $this->sectionModelToEntityMapper = $sectionModelToEntityMapper;
        $this->userRepository = $userRepository;
        $this->changeSectionPositionService = $changeSectionPositionService;
    }

    /**
     * @param SectionInterface $section
     */
    public function create(SectionInterface $section)
    {
        /** @var SectionEntity $sectionEntity */
        $sectionEntity = $this->sectionModelToEntityMapper->mapNew($section);

        $this->entityManager->persist($sectionEntity);
        $this->entityManager->flush();
    }

    /**
     * @param SectionInterface $section
     */
    public function update(SectionInterface $section)
    {
        $this->sectionModelToEntityMapper->map($section);

        $this->entityManager->flush();
    }

    /**
     * @param SectionInterface $section
     */
    public function createOrUpdate(SectionInterface $section)
    {
        try {
            /** @var  $sectionEntity SectionEntity */
            $sectionEntity = $this->sectionModelToEntityMapper->map($section);
        } catch (EntityNotFound $exception) {
            $sectionEntity = $this->sectionModelToEntityMapper->mapNew($section);
        }

        $this->entityManager->persist($sectionEntity);
        $this->entityManager->flush();
    }

    /**
     * @param SectionInterface $section
     */
    public function delete(SectionInterface $section): void
    {
        /** @var  $sectionEntity SectionEntity */
        $sectionEntity = $this->sectionModelToEntityMapper->map($section);

        $this->entityManager->remove($sectionEntity);
        $this->entityManager->flush();
    }

    /**
     * @param SectionInterface $section
     * @param int $positionToChange
     * @param int $modifiedById
     * @throws Exception
     */
    public function changePosition(SectionInterface $section, int $positionToChange, int $modifiedById):void
    {
        /** @var UserEntity $userEntity */
        $userEntity = $this->userRepository->find($modifiedById);
        /** @var int $currentSectionPosition */
        $currentSectionPosition = $section->getPosition();

        if ($currentSectionPosition > $positionToChange) {
            $this->changeSectionPositionService->increaseSectionListInPosition(
                $section,
                $positionToChange,
                $userEntity
            );
        } else {
            $this->changeSectionPositionService->decreaseSectionListInPosition(
                $section,
                $positionToChange,
                $userEntity
            );
        }

        /** @var  $sectionEntity SectionEntity */
        $sectionEntity = $this->sectionModelToEntityMapper->map($section);
        $sectionEntity->setPosition($positionToChange);
        $sectionEntity->setModifiedBy($userEntity);
        $sectionEntity->setUpdatedAt(new DateTime());

        $this->entityManager->flush();
    }
}
