<?php

namespace App\Core\Service\Item;

use App\Core\Model\Paragraph\ParagraphId;

interface PositionIteratorInterface
{
    public function next(ParagraphId $paragraph): int;
}