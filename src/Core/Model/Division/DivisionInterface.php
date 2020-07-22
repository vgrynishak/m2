<?php

namespace App\Core\Model\Division;

use App\Core\Model\ModelInterface;

interface DivisionInterface extends ModelInterface
{
    public function getId(): DivisionId;

    public function getName(): string;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;

    public function getAlias(): string;
}
