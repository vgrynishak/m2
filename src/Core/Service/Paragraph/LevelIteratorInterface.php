<?php

namespace App\Core\Service\Paragraph;

use App\Core\Model\Paragraph\BaseParagraphInterface;

interface LevelIteratorInterface
{
    public function next(BaseParagraphInterface $paragraph): int;
}
