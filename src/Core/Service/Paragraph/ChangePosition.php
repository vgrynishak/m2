<?php

namespace App\Core\Service\Paragraph;

use App\App\Doctrine\Entity\User as UserEntity;
use App\App\Doctrine\Entity\Paragraph as ParagraphEntity;
use App\App\Doctrine\Repository\ParagraphRepository;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use DateTime;
use Exception;

class ChangePosition implements ChangePositionInterface
{
    /** @var ParagraphRepository */
    private $paragraphRepository;

    /**
     * ChangePosition constructor.
     * @param ParagraphRepository $paragraphRepository
     */
    public function __construct(ParagraphRepository $paragraphRepository)
    {
        $this->paragraphRepository = $paragraphRepository;
    }

    /**
     * @param BaseParagraphInterface $paragraph
     * @param int $positionToChange
     * @param UserEntity $user
     * @throws Exception
     */
    public function increaseParagraphListInPosition(
        BaseParagraphInterface $paragraph,
        int $positionToChange,
        UserEntity $user
    ): void {
        /** @var ParagraphEntity[] $paragraphsEntity */
        $paragraphsEntity = $this->paragraphRepository->getListWhoNeedIncreaseInPosition($paragraph, $positionToChange);
        /** @var ParagraphEntity $paragraphEntity */
        foreach ($paragraphsEntity as $paragraphEntity) {
            /** @var int $resultPosition */
            $resultPosition = $paragraphEntity->getPosition() + 1;
            $this->changeBaseFields($paragraphEntity, $resultPosition, $user);
        }
    }

    /**
     * @param BaseParagraphInterface $paragraph
     * @param int $positionToChange
     * @param UserEntity $user
     * @throws Exception
     */
    public function decreaseParagraphListInPosition(
        BaseParagraphInterface $paragraph,
        int $positionToChange,
        UserEntity $user
    ): void {
        /** @var ParagraphEntity[] $paragraphsEntity */
        $paragraphsEntity = $this->paragraphRepository->getListWhoNeedDecreaseInPosition($paragraph, $positionToChange);
        /** @var ParagraphEntity $paragraphEntity */
        foreach ($paragraphsEntity as $paragraphEntity) {
            /** @var int $resultPosition */
            $resultPosition = $paragraphEntity->getPosition() - 1;
            $this->changeBaseFields($paragraphEntity, $resultPosition, $user);
        }
    }

    /**
     * @param ParagraphEntity $paragraphEntity
     * @param int $resultPosition
     * @param UserEntity $user
     * @throws Exception
     */
    public function changeBaseFields(ParagraphEntity $paragraphEntity, int $resultPosition, UserEntity $user): void
    {
        $paragraphEntity->setPosition($resultPosition);
        $paragraphEntity->setModifiedBy($user);
        $paragraphEntity->setUpdatedAt(new DateTime());
    }
}
