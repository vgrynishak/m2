<?php

namespace App\App\Factory\Paragraph;

use App\Core\Model\Paragraph\StyleTemplateInterface;

interface StyleTemplateFactoryInterface
{
    public function make(string $id, string $name): StyleTemplateInterface;
}
