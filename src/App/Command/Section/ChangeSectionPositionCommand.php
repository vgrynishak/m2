<?php

namespace App\App\Command\Section;

use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;

class ChangeSectionPositionCommand implements ChangeSectionPositionCommandInterface
{
    /** @var SectionId */
    private $id;
    /** @var int */
    private $newPosition;
    /** @var UserInterface */
    private $modifiedBy;

    /**
     * ChangeSectionPositionCommand constructor.
     * @param SectionId $id
     * @param int $newPosition
     * @param UserInterface $modifiedBy
     */
    public function __construct(SectionId $id, int $newPosition, UserInterface $modifiedBy)
    {
        $this->id = $id;
        $this->newPosition = $newPosition;
        $this->modifiedBy = $modifiedBy;
    }

    /**
     * @return SectionId
     */
    public function getId(): SectionId
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getNewPosition(): int
    {
        return $this->newPosition;
    }

    /**
     * @return UserInterface
     */
    public function getModifiedBy(): UserInterface
    {
        return $this->modifiedBy;
    }
}
