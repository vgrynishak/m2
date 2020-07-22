<?php

namespace App\App\Query\InfoSource;

use App\Core\Model\Item\InformationItem\Dictionary\DictionaryId;

class InfoSourceListByDictionaryIdQuery implements InfoSourceListByDictionaryIdQueryInterface
{
    /** @var DictionaryId */
    private $id;

    /**
     * InfoSourceListByDictionaryIdQuery constructor.
     * @param DictionaryId $id
     */
    public function __construct(DictionaryId $id)
    {
        $this->id = $id;
    }

    /**
     * @return DictionaryId
     */
    public function getId(): DictionaryId
    {
        return $this->id;
    }
}
