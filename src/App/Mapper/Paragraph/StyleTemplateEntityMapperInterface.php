<?php

namespace App\App\Mapper\Paragraph;

use App\App\Doctrine\Entity\StyleTemplate as StyleTemplateEntity;
use App\Core\Model\Paragraph\StyleTemplateInterface;

interface StyleTemplateEntityMapperInterface
{
    public function map(StyleTemplateEntity $styleTemplateEntity): StyleTemplateInterface;
}
