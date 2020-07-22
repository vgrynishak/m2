<?php

namespace App\App\Command\Section;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;

interface DeleteSectionCommandInterface extends MessageInterface
{
    /**
     * @return SectionId
     */
    public function getId(): SectionId;

    /**
     * @return UserInterface
     */
    public function getModifiedBy(): UserInterface;
}
