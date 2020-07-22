<?php

namespace App\App\Doctrine\Entity\Item;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass="App\App\Doctrine\Repository\Item\ItemTypeRepository")
 * @ORM\Table(name="item_type",uniqueConstraints={@UniqueConstraint(name="uuid_idx", columns={"id"})})
 */
class ItemType
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=36, nullable=false)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\Item\ItemCategory")
     * @ORM\JoinColumn(name="item_category_id", nullable=false)
     */
    private $itemCategory;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $position;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return ItemType
     */
    public function setId(string $id): ItemType
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ItemCategory
     */
    public function getItemCategory(): ItemCategory
    {
        return $this->itemCategory;
    }

    /**
     * @param ItemCategory $itemCategory
     * @return ItemType
     */
    public function setItemCategory(ItemCategory $itemCategory): ItemType
    {
        $this->itemCategory = $itemCategory;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ItemType
     */
    public function setName(string $name): ItemType
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string | null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return ItemType
     */
    public function setDescription(?string $description): ItemType
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return ItemType
     */
    public function setPosition(int $position): ItemType
    {
        $this->position = $position;

        return $this;
    }
}
