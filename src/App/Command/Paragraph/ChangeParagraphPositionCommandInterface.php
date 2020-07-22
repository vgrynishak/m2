<?php

namespace App\App\Command\Paragraph;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\User\UserInterface;

interface ChangeParagraphPositionCommandInterface extends MessageInterface
{
    /**
     * @return ParagraphId
     */
    public function getId(): ParagraphId;

    /**
     * @return int
     */
    public function getNewPosition(): int;

    /**
     * @return UserInterface
     */
    public function getModifiedBy(): UserInterface;
}
