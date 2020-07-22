<?php

namespace App\App\Mapper\Section;

use App\App\Doctrine\Entity\Section as SectionEntity;
use App\Core\Model\Section\SectionInterface;

interface DoctrineEntitySectionMapperInterface
{
    public function map(SectionEntity $sectionEntity): SectionInterface;
}
