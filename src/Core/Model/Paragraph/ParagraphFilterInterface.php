<?php

namespace App\Core\Model\Paragraph;

use App\Core\Model\ModelInterface;

interface ParagraphFilterInterface extends ModelInterface
{
    public function getId(): ParagraphFilterId;

    public function getName(): string;

    public function getDescription(): ?string;

    public function setDescription(?string $description);
}
