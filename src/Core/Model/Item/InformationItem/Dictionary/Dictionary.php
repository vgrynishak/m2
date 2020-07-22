<?php

namespace App\Core\Model\Item\InformationItem\Dictionary;

class Dictionary implements DictionaryInterface
{
    /** @var DictionaryId */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $description;

    /**
     * Dictionary constructor.
     * @param DictionaryId $id
     * @param string $name
     */
    public function __construct(DictionaryId $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return DictionaryId
     */
    public function getId(): DictionaryId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
