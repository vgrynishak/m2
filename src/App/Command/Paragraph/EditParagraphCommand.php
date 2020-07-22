<?php

namespace App\App\Command\Paragraph;

use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\User\UserInterface;

class EditParagraphCommand implements EditParagraphCommandInterface
{
    /** @var ParagraphId */
    private $id;
    /** @var UserInterface */
    private $modifiedBy;
    /** @var BaseHeaderInterface */
    private $header;

    /**
     * EditParagraphCommand constructor.
     * @param ParagraphId $id
     * @param BaseHeaderInterface $header
     * @param UserInterface $modifiedBy
     */
    public function __construct(ParagraphId $id, BaseHeaderInterface $header, UserInterface $modifiedBy)
    {
        $this->id = $id;
        $this->header = $header;
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
     * @return BaseHeaderInterface
     */
    public function getHeader(): BaseHeaderInterface
    {
        return $this->header;
    }

    /**
     * @return UserInterface
     */
    public function getModifiedBy(): UserInterface
    {
        return $this->modifiedBy;
    }
}
