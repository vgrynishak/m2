<?php

namespace App\App\Command\Section;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;

interface EditSectionCommandInterface extends MessageInterface
{
    /**
     * @return SectionId
     */
    public function getId(): SectionId;

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return UserInterface
     */
    public function getModifiedBy(): UserInterface;
}
