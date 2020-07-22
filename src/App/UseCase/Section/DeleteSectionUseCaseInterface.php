<?php

namespace App\App\UseCase\Section;

use App\App\Command\Section\DeleteSectionCommandInterface;

interface DeleteSectionUseCaseInterface
{
    /**
     * @param DeleteSectionCommandInterface $command
     */
    public function delete(DeleteSectionCommandInterface $command): void;
}
