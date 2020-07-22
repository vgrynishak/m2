<?php

namespace App\App\Doctrine\Entity\ReportForm;

use App\App\Doctrine\Entity\Item\Item;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\App\Doctrine\Repository\ReportForm\ElementRepository")
 * @ORM\Table(name="element")
 */
class Element
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=36, nullable=false)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\Item\Item")
     * @ORM\JoinColumn(name="item_id", nullable=false)
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\ReportForm\Container")
     * @ORM\JoinColumn(name="containerId", nullable=false)
     */
    private $container;

    /**
     * @ORM\Column(name="filled", type="boolean", nullable=false)
     */
    private $filled;

    /**
     * @ORM\Column(type="json_array", nullable=false)
     */
    private $value;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Element
     */
    public function setId(string $id): Element
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Item
     */
    public function getItem(): ?Item
    {
        return $this->item;
    }

    /**
     * @param Item $item
     * @return Element
     */
    public function setItem(Item $item): Element
    {
        $this->item = $item;
        return $this;
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * @param Container $container
     * @return Element
     */
    public function setContainer(Container $container): Element
    {
        $this->container = $container;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getFilled(): bool
    {
        return $this->filled;
    }

    /**
     * @param bool $filled
     * @return Element
     */
    public function setFilled(bool $filled): Element
    {
        $this->filled = $filled;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return Element
     */
    public function setValue($value): Element
    {
        $this->value = $value;
        return $this;
    }
}
