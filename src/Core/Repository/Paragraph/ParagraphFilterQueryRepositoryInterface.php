<?php

namespace App\Core\Repository\Paragraph;

use App\Core\Model\Paragraph\ParagraphFilterId;
use App\Core\Model\Paragraph\ParagraphFilterInterface;

interface ParagraphFilterQueryRepositoryInterface
{
    public function find(ParagraphFilterId $id): ?ParagraphFilterInterface;
}
