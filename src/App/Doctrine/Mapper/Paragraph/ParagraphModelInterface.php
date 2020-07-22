<?php

namespace App\App\Doctrine\Mapper\Paragraph;

use App\App\Doctrine\Entity\Paragraph as ParagraphEntity;
use App\Core\Model\Paragraph\BaseParagraphInterface;

interface ParagraphModelInterface
{
    /**
     * @param BaseParagraphInterface $paragraphModel
     *
     * @return ParagraphEntity
     */
    public function mapNew(BaseParagraphInterface $paragraphModel): ParagraphEntity;

    /**
     * @param BaseParagraphInterface $paragraphModel
     *
     * @return ParagraphEntity
     */
    public function map(BaseParagraphInterface $paragraphModel): ParagraphEntity;
}
