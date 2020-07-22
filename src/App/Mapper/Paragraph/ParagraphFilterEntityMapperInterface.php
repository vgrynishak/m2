<?php

namespace App\App\Mapper\Paragraph;

use App\Core\Model\Paragraph\ParagraphFilterInterface;
use App\App\Doctrine\Entity\ParagraphFilter as ParagraphFilterEntity;


interface ParagraphFilterEntityMapperInterface
{
    public function map(ParagraphFilterEntity $paragraphFilterEntity): ParagraphFilterInterface;
}
