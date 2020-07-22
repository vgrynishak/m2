<?php

namespace App\App\UseCase\Section;

use App\App\Command\Section\CreateSectionCommand;
use App\Core\Model\Section\SectionInterface;

interface CreateSectionUseCaseInterface
{
    /**
     * @param CreateSectionCommand $command
     * @return SectionInterface
     */
    public function create(CreateSectionCommand $command): SectionInterface;
}
