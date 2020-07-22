<?php

namespace App\App\Command\Section;

use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;

class DeleteSectionCommand implements DeleteSectionCommandInterface
{
    /** @var SectionId */
    private $id;
    /** @var UserInterface */
    private $modifiedBy;

    /**
     * DeleteSectionCommand constructor.
     * @param SectionId $id
     * @param UserInterface $modifiedBy
     */
    public function __construct(SectionId $id, UserInterface $modifiedBy)
    {
        $this->id = $id;
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
     * @return UserInterface
     */
    public function getModifiedBy(): UserInterface
    {
        return $this->modifiedBy;
    }
}
