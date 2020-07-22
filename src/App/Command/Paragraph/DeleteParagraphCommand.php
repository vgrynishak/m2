<?php

namespace App\App\Command\Paragraph;

use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\User\UserInterface;

class DeleteParagraphCommand implements DeleteParagraphCommandInterface
{
    /** @var ParagraphId */
    private $id;
    /** @var UserInterface */
    private $modifiedBy;

    /**
     * DeleteParagraphCommand constructor.
     * @param ParagraphId $id
     * @param UserInterface $modifiedBy
     */
    public function __construct(ParagraphId $id, UserInterface $modifiedBy)
    {
        $this->id = $id;
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
     * @return UserInterface
     */
    public function getModifiedBy(): UserInterface
    {
        return $this->modifiedBy;
    }
}