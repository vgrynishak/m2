<?php

namespace App\App\Mapper\Paragraph;

use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\App\Doctrine\Entity\Paragraph as ParagraphEntity;

interface DoctrineEntityParagraphMapperInterface
{
    public function map(ParagraphEntity $paragraphEntity): BaseParagraphInterface;
}
