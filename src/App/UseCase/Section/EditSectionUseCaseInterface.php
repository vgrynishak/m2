<?php

namespace App\App\UseCase\Section;

use App\App\Command\Section\EditSectionCommandInterface;
use App\Core\Model\Section\SectionInterface;

interface EditSectionUseCaseInterface
{
    /**
     * @param EditSectionCommandInterface $command
     * @return SectionInterface
     */
    public function edit(EditSectionCommandInterface $command): SectionInterface;
}
