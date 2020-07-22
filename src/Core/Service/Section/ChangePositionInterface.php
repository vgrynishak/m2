<?php

namespace App\Core\Service\Section;

use App\App\Doctrine\Entity\User as UserEntity;
use App\Core\Model\Section\SectionInterface;

interface ChangePositionInterface
{
    /**
     * @param SectionInterface $section
     * @param int $positionToChange
     * @param UserEntity $user
     */
    public function decreaseSectionListInPosition(
        SectionInterface $section,
        int $positionToChange,
        UserEntity $user
    ): void;

    /**
     * @param SectionInterface $section
     * @param int $positionToChange
     * @param UserEntity $user
     */
    public function increaseSectionListInPosition(
        SectionInterface $section,
        int $positionToChange,
        UserEntity $user
    ): void;
}
