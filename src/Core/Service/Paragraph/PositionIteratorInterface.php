<?php

namespace App\Core\Service\Paragraph;

use App\Core\Model\Paragraph\BaseParagraphInterface;

interface PositionIteratorInterface
{
    public function next(BaseParagraphInterface $paragraph): int;
}
