<?php

namespace App\App\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\App\Doctrine\Repository\DeviceInstanceRepository")
 * @ORM\Table(name="device_instance")
 */
class DeviceInstance
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=36, nullable=false)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\Device")
     *
     * @ORM\JoinColumn(name="device_id", referencedColumnName="id", nullable=false)
     */
    private $device;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\Facility")
     *
     * @ORM\JoinColumn(name="facility_id", referencedColumnName="id", nullable=false)
     */
    private $facility;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\DeviceInstance")
     */
    private $parent;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\User")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\User")
     */
    private $modifiedBy;

    /**
     * @ORM\Column(type="timestamp")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="timestamp")
     */
    private $updatedAt;

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
     * @return Device
     */
    public function getDevice(): Device
    {
        return $this->device;
    }

    /**
     * @param Device $device
     * @return $this
     */
    public function setDevice(Device $device): self
    {
        $this->device = $device;

        return $this;
    }

    /**
     * @return Facility
     */
    public function getFacility(): Facility
    {
        return $this->facility;
    }

    /**
     * @param Facility $facility
     * @return $this
     */
    public function setFacility(Facility $facility): self
    {
        $this->facility = $facility;

        return $this;
    }

    /**
     * @return DeviceInstance|null
     */
    public function getParent(): ?DeviceInstance
    {
        return $this->parent;
    }

    /**
     * @param DeviceInstance $parent
     * @return $this
     */
    public function setParent(DeviceInstance $parent): self
    {
        $this->parent = $parent;

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
