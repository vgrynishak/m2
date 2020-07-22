<?php

namespace App\Core\Model\Item\InformationItem\InfoSource;

use App\Core\Model\Item\InformationItem\Dictionary\DictionaryId;

class InfoSource implements InfoSourceInterface
{
    /** @var InfoSourceId */
    private $id;
    /** @var string */
    private $name;
    /** @var DictionaryId */
    private $dictionaryId;

    /**
     * InfoSource constructor.
     * @param InfoSourceId $id
     * @param DictionaryId $dictionaryId
     * @param string $name
     */
    public function __construct(InfoSourceId $id, DictionaryId $dictionaryId, string $name)
    {
        $this->id = $id;
        $this->dictionaryId = $dictionaryId;
        $this->name = $name;
    }

    public function getId(): InfoSourceId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDictionary(): DictionaryId
    {
        return $this->dictionaryId;
    }
}
