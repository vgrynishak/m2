<?php

namespace App\Core\Repository\Paragraph;

use App\Core\Model\Paragraph\BaseParagraphInterface;

interface ParagraphCommandRepositoryInterface
{
    /**
     * @param BaseParagraphInterface $paragraph
     */
    public function create(BaseParagraphInterface $paragraph): void;

    /**
     * @param BaseParagraphInterface $paragraph
     */
    public function update(BaseParagraphInterface $paragraph): void;

    /**
     * @param BaseParagraphInterface $section
     * @param int $positionToChange
     * @param int $modifiedById
     */
    public function changePosition(BaseParagraphInterface $section, int $positionToChange, int $modifiedById): void;

    /**
     * @param BaseParagraphInterface $paragraph
     */
    public function delete(BaseParagraphInterface $paragraph): void;
}
