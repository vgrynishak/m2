<?php


namespace App\App\Doctrine\Entity\Item;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass="App\App\Doctrine\Repository\Item\DictionaryRepository")
 * @ORM\Table(name="dictionary",uniqueConstraints={@UniqueConstraint(name="uuid_idx", columns={"id"})})
 */
class Dictionary
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=36, nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Dictionary
     */
    public function setId(string $id): Dictionary
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Dictionary
     */
    public function setName(string $name): Dictionary
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Dictionary
     */
    public function setDescription(?string $description): Dictionary
    {
        $this->description = $description;
        return $this;
    }
}
