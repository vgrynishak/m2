<?php

namespace App\App\Query\InfoSource;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Item\InformationItem\Dictionary\DictionaryId;

interface InfoSourceListByDictionaryIdQueryInterface extends MessageInterface
{
    /**
     * @return DictionaryId
     */
    public function getId(): DictionaryId;
}
