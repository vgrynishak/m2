<?php

namespace App\App\Command\ReportTemplate;

use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\User\User;

class DuplicateCommand
{
    /** @var ReportTemplateId */
    private $id;
    /** @var User */
    private $user;

    /**
     * DuplicateCommand constructor.
     * @param ReportTemplateId $id
     * @param User $user
     */
    public function __construct(ReportTemplateId $id, User $user)
    {
        $this->id = $id;
        $this->user = $user;
    }

    /**
     * @return ReportTemplateId
     */
    public function getId() : ReportTemplateId
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser() : User
    {
        return $this->user;
    }
}
