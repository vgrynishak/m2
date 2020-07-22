<?php

namespace App\App\Doctrine\Entity\Item;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass="App\App\Doctrine\Repository\Item\InfoSourceRepository")
 * @ORM\Table(name="info_source",uniqueConstraints={@UniqueConstraint(name="uuid_idx", columns={"id"})})
 */
class InfoSource
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=125, nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\Item\Dictionary")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dictionary;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return InfoSource
     */
    public function setId($id): InfoSource
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
     * @return InfoSource
     */
    public function setName($name): InfoSource
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Dictionary
     */
    public function getDictionary(): Dictionary
    {
        return $this->dictionary;
    }

    /**
     * @param Dictionary $dictionary
     * @return InfoSource
     */
    public function setDictionary(Dictionary $dictionary): InfoSource
    {
        $this->dictionary = $dictionary;
        return $this;
    }
}
