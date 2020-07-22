<?php

namespace App\App\UseCase\Paragraph;

use App\App\Command\Paragraph\EditParagraphCommandInterface;
use App\Core\Model\Paragraph\BaseParagraphInterface;

interface EditParagraphUseCaseInterface
{
    public function edit(EditParagraphCommandInterface $command): BaseParagraphInterface;
}
