<?php

namespace App\Core\Service\Paragraph;

use App\App\Doctrine\Entity\User as UserEntity;
use App\Core\Model\Paragraph\BaseParagraphInterface;

interface ChangePositionInterface
{
    /**
     * @param BaseParagraphInterface $paragraph
     * @param int $positionToChange
     * @param UserEntity $user
     */
    public function decreaseParagraphListInPosition(
        BaseParagraphInterface $paragraph,
        int $positionToChange,
        UserEntity $user
    ): void;

    /**
     * @param BaseParagraphInterface $paragraph
     * @param int $positionToChange
     * @param UserEntity $user
     */
    public function increaseParagraphListInPosition(
        BaseParagraphInterface $paragraph,
        int $positionToChange,
        UserEntity $user
    ): void;
}
