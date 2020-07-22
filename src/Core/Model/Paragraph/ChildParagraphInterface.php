<?php

namespace App\Core\Model\Paragraph;

interface ChildParagraphInterface extends BaseParagraphInterface
{
    public function getLevel(): int;

    public function getParent(): ParagraphId;
}
