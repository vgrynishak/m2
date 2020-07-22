<?php

namespace App\Core\Model\Division;

class Division implements DivisionInterface
{
    /** @var DivisionId  */
    private $id;
    /** @var string  */
    private $alias;
    /** @var string  */
    private $name;
    /** @var string|null */
    private $description;

    /**
     * Division constructor.
     * @param DivisionId $id
     * @param string $alias
     * @param string $name
     */
    public function __construct(DivisionId $id, string $alias, string $name)
    {
        $this->id = $id;
        $this->alias = $alias;
        $this->name = $name;
    }

    /**
     * @return DivisionId
     */
    public function getId(): DivisionId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
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
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
