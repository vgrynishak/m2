<?php

namespace App\Infrastructure\Adapter\DTO\DeviceDynamicField;

class Full
{
    /** @var string */
    private $id;
    /** @var string */
    private $dictionaryId;
    /** @var string */
    private $name;

    /**
     * Full constructor.
     * @param string $id
     * @param string $dictionaryId
     * @param string $name
     */
    public function __construct(string $id, string $dictionaryId, string $name)
    {
        $this->id = $id;
        $this->dictionaryId = $dictionaryId;
        $this->name = $name;
    }
}
