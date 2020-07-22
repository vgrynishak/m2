<?php

namespace App\App\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\App\Doctrine\Repository\DeviceDynamicFieldRepository")
 * @ORM\Table(name="device_dynamic_field")
 */
class DeviceDynamicField
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\Device", inversedBy="dynamicFields")
     *
     * @ORM\JoinColumn(name="device_id", referencedColumnName="id", nullable=false)
     */
    private $device;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $name;

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
}
