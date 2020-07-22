<?php

namespace App\Core\Model\Item\InformationItem\Dictionary;

interface DictionaryInterface
{
    public function getId(): DictionaryId;

    public function getName(): string;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;
}
