<?php

namespace App\App\Repository\Paragraph;

use App\App\Doctrine\Entity\Paragraph as ParagraphEntity;
use App\App\Doctrine\Mapper\Exception\FailMapModelToEntity;
use App\App\Doctrine\Repository\UserRepository;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Repository\Item\ItemCommandRepositoryInterface;
use App\Core\Repository\Paragraph\ParagraphCommandRepositoryInterface;
use App\Core\Service\Paragraph\ChangePositionInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use App\App\Doctrine\Mapper\Paragraph\ParagraphModelInterface;
use App\App\Doctrine\Entity\User as UserEntity;
use Exception;
use PhpCollection\CollectionInterface;

class ParagraphCommandRepository implements ParagraphCommandRepositoryInterface
{
    /** @var EntityManagerInterface */
    protected $entityManager;
    /** @var ParagraphModelInterface */
    private $paragraphModelMapper;
    /** @var UserRepository */
    private $userRepository;
    /** @var ChangePositionInterface */
    private $changeParagraphPositionService;
    /** @var ItemCommandRepositoryInterface */
    private $itemCommandRepository;

    /**
     * ParagraphCommandRepository constructor.
     * @param EntityManagerInterface $entityManager
     * @param ParagraphModelInterface $paragraphModelMapper
     * @param UserRepository $userRepository
     * @param ChangePositionInterface $changeParagraphPositionService
     * @param ItemCommandRepositoryInterface $itemCommandRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ParagraphModelInterface $paragraphModelMapper,
        UserRepository $userRepository,
        ChangePositionInterface $changeParagraphPositionService,
        ItemCommandRepositoryInterface $itemCommandRepository
    ) {
        $this->entityManager = $entityManager;
        $this->paragraphModelMapper = $paragraphModelMapper;
        $this->userRepository = $userRepository;
        $this->changeParagraphPositionService = $changeParagraphPositionService;
        $this->itemCommandRepository = $itemCommandRepository;
    }

    /**
     * @param BaseParagraphInterface $paragraphModel
     *
     * @throws FailMapModelToEntity
     */
    public function create(BaseParagraphInterface $paragraphModel): void
    {
        /** @var ParagraphEntity $paragraphEntity */
        $paragraphEntity = $this->paragraphModelMapper->mapNew($paragraphModel);
        if (!$paragraphEntity instanceof ParagraphEntity) {
            throw new FailMapModelToEntity("Fail map Paragraph model to entity");
        }

        $this->entityManager->persist($paragraphEntity);
        $this->entityManager->flush();
    }

    /**
     * @param BaseParagraphInterface $paragraph
     * @throws FailMapModelToEntity
     */
    public function update(BaseParagraphInterface $paragraph): void
    {
        /** @var ParagraphEntity $paragraphEntity */
        $paragraphEntity = $this->paragraphModelMapper->map($paragraph);
        if (!$paragraphEntity instanceof ParagraphEntity) {
            throw new FailMapModelToEntity("Fail map Paragraph model to entity");
        }

        $this->entityManager->persist($paragraphEntity);
        $this->entityManager->flush();
    }

    /**
     * @param BaseParagraphInterface $paragraph
     */
    public function delete(BaseParagraphInterface $paragraph): void
    {
        /** @var CollectionInterface | null $paragraphItems */
        $paragraphItems = $paragraph->getItems();

        if ($paragraphItems instanceof CollectionInterface) {
            $this->itemCommandRepository->deleteList($paragraphItems);
        }

        /** @var ParagraphEntity $paragraphEntity */
        $paragraphEntity = $this->paragraphModelMapper->map($paragraph);

        $this->entityManager->remove($paragraphEntity);
        $this->entityManager->flush();
    }

    /**
     * @param BaseParagraphInterface $paragraph
     * @param int $positionToChange
     * @param int $modifiedById
     * @throws Exception
     */
    public function changePosition(BaseParagraphInterface $paragraph, int $positionToChange, int $modifiedById): void
    {
        /** @var UserEntity $userEntity */
        $userEntity = $this->userRepository->find($modifiedById);
        /** @var int $currentParagraphPosition */
        $currentParagraphPosition = $paragraph->getPosition();

        if ($currentParagraphPosition > $positionToChange) {
            $this->changeParagraphPositionService->increaseParagraphListInPosition(
                $paragraph,
                $positionToChange,
                $userEntity
            );
        } else {
            $this->changeParagraphPositionService->decreaseParagraphListInPosition(
                $paragraph,
                $positionToChange,
                $userEntity
            );
        }

        /** @var  $sectionEntity $paragraphEntity */
        $paragraphEntity = $this->paragraphModelMapper->map($paragraph);
        $paragraphEntity->setPosition($positionToChange);
        $paragraphEntity->setModifiedBy($userEntity);
        $paragraphEntity->setUpdatedAt(new DateTime());

        $this->entityManager->flush();
    }
}
