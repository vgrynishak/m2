<?php

namespace App\App\Command\Paragraph;

use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\User\UserInterface;

interface DeleteParagraphCommandInterface
{
    /**
     * @return ParagraphId
     */
    public function getId(): ParagraphId;

    /**
     * @return UserInterface
     */
    public function getModifiedBy(): UserInterface;
}
