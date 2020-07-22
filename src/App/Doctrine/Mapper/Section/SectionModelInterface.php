<?php

namespace App\App\Doctrine\Mapper\Section;

use App\Core\Model\Section\SectionInterface;
use App\App\Doctrine\Entity\Section as SectionEntity;

interface SectionModelInterface
{
    /**
     * @param SectionInterface $sectionModel
     * @return SectionEntity
     */
    public function map(SectionInterface $sectionModel): SectionEntity;

    /**
     * @param SectionInterface $sectionModel
     * @return SectionEntity
     */
    public function mapNew(SectionInterface $sectionModel): SectionEntity;
}
