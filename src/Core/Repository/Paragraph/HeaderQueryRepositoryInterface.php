<?php

namespace App\Core\Repository\Paragraph;

use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Paragraph\ParagraphId;

interface HeaderQueryRepositoryInterface
{
    /**
     * @param ParagraphId $paragraphId
     * @return BaseHeaderInterface|null
     */
    public function findByParagraphId(ParagraphId $paragraphId): ?BaseHeaderInterface;
}
