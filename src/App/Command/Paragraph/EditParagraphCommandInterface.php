<?php

namespace App\App\Command\Paragraph;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\User\UserInterface;

interface EditParagraphCommandInterface extends MessageInterface
{
    /**
     * @return ParagraphId
     */
    public function getId(): ParagraphId;

    /**
     * @return UserInterface
     */
    public function getModifiedBy(): UserInterface;

    /**
     * @return BaseHeaderInterface
     */
    public function getHeader(): BaseHeaderInterface;
}
