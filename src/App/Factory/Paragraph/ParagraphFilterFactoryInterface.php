<?php

namespace App\App\Factory\Paragraph;

use App\Core\Model\Paragraph\ParagraphFilterInterface;

interface ParagraphFilterFactoryInterface
{
    public function make(string $alias, string $name): ParagraphFilterInterface;
}
