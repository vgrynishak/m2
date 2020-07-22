<?php

namespace App\App\Command\Section;

use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;

class EditSectionCommand implements EditSectionCommandInterface
{
    /** @var SectionId */
    private $id;
    /** @var string */
    private $title;
    /** @var UserInterface */
    private $modifiedBy;

    /**
     * EditSectionCommand constructor.
     * @param SectionId $id
     * @param string $title
     * @param UserInterface $modifiedBy
     */
    public function __construct(SectionId $id, string $title, UserInterface $modifiedBy)
    {
        $this->id = $id;
        $this->title = $title;
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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return UserInterface
     */
    public function getModifiedBy(): UserInterface
    {
        return $this->modifiedBy;
    }
}
