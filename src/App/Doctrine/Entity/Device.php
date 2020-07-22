<?php

namespace App\App\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use PhpCollection\CollectionInterface;

/**
 * @ORM\Entity(repositoryClass="App\App\Doctrine\Repository\DeviceRepository")
 * @ORM\Table(name="device")
 */
class Device
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=36, nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $alias;

    /**
     * @ORM\Column(type="timestamp")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="timestamp")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\Device")
     */
    private $parent;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\Division")
     *
     * @ORM\JoinColumn(name="division_id", referencedColumnName="id", nullable=false)
     */
    private $division;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", length=10, nullable=false)
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\User")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\User")
     */
    private $modifiedBy;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId(string $id): self
    {
        $this->id = $id;

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
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     * @return $this
     */
    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Device|null
     */
    public function getParent(): ?Device
    {
        return $this->parent;
    }

    /**
     * @param Device|null $parent
     * @return $this
     */
    public function setParent(?Device $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @param int $level
     * @return $this
     */
    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param string|null $description
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param Division $division
     * @return $this
     */
    public function setDivision(Division $division): self
    {
        $this->division = $division;

        return $this;
    }

    /**
     * @return Division
     */
    public function getDivision(): Division
    {
        return $this->division;
    }

    /**
     * @return User|null
     */
    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    /**
     * @param User|null $createdBy
     * @return $this
     */
    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getModifiedBy(): ?User
    {
        return $this->modifiedBy;
    }

    /**
     * @param User|null $modifiedBy
     * @return $this
     */
    public function setModifiedBy(?User $modifiedBy): self
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }
}
