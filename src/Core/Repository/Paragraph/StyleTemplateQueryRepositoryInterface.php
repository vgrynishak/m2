<?php

namespace App\Core\Repository\Paragraph;

use App\Core\Model\Paragraph\StyleTemplateId;
use App\Core\Model\Paragraph\StyleTemplateInterface;

interface StyleTemplateQueryRepositoryInterface
{
    public function find(StyleTemplateId $id): ?StyleTemplateInterface;
}
