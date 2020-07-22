<?php

namespace App\App\Mapper\Paragraph;

use App\App\Doctrine\Entity\HeaderType as HeaderTypeEntity;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;

interface DoctrineEntityHeaderMapperInterface
{
    /**
     * @param HeaderTypeEntity $headerTypeEntity
     * @param string|null $value
     * @return BaseHeaderInterface
     */
    public function map(HeaderTypeEntity $headerTypeEntity, ?string $value): BaseHeaderInterface;
}
