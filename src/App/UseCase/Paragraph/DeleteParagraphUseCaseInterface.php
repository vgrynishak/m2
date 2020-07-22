<?php

namespace App\App\UseCase\Paragraph;

use App\App\Command\Paragraph\DeleteParagraphCommandInterface;

interface DeleteParagraphUseCaseInterface
{
    /**
     * @param DeleteParagraphCommandInterface $command
     */
    public function delete(DeleteParagraphCommandInterface $command): void;
}
