<?php

namespace App\App\Command\Paragraph;

use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\User\UserInterface;

class ChangeParagraphPositionCommand implements ChangeParagraphPositionCommandInterface
{
    /** @var ParagraphId */
    private $id;
    /** @var int */
    private $newPosition;
    /** @var UserInterface */
    private $modifiedBy;

    /**
     * ChangeParagraphPositionCommand constructor.
     * @param ParagraphId $id
     * @param int $newPosition
     * @param UserInterface $modifiedBy
     */
    public function __construct(ParagraphId $id, int $newPosition, UserInterface $modifiedBy)
    {
        $this->id = $id;
        $this->newPosition = $newPosition;
        $this->modifiedBy = $modifiedBy;
    }

    /**
     * @return ParagraphId
     */
    public function getId(): ParagraphId
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
