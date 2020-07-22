<?php

namespace App\Core\Model\Item\InformationItem\InfoSource;

use App\Core\Model\Item\InformationItem\Dictionary\DictionaryId;

interface InfoSourceInterface
{
    public function getId(): InfoSourceId;

    public function getName(): string;

    public function getDictionary(): DictionaryId;
}
