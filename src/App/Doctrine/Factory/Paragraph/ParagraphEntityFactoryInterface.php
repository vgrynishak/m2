<?php

namespace App\App\Doctrine\Factory\Paragraph;

use App\App\Doctrine\Entity\Paragraph as ParagraphEntity;
use App\Core\Model\Paragraph\BaseParagraphInterface;

interface ParagraphEntityFactoryInterface
{
    /**
     * @param BaseParagraphInterface $paragraphModel
     *
     * @return ParagraphEntity
     */
    public function makeByModel(BaseParagraphInterface $paragraphModel): ParagraphEntity;

    /**
     * @param BaseParagraphInterface $paragraphModel
     *
     * @return ParagraphEntity
     */
    public function makeNewByModel(BaseParagraphInterface $paragraphModel): ParagraphEntity;
}
