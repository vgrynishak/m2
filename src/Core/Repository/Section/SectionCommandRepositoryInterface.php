<?php

namespace App\Core\Repository\Section;

use App\Core\Model\Section\SectionInterface;

interface SectionCommandRepositoryInterface
{
    public function create(SectionInterface $section);

    public function update(SectionInterface $section);

    public function createOrUpdate(SectionInterface $section);

    public function changePosition(SectionInterface $section, int $positionToChange, int $modifiedById): void;

    public function delete(SectionInterface $section): void;
}
