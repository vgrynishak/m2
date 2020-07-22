<?php

namespace App\App\Doctrine\Entity\ReportForm;

use App\App\Doctrine\Entity\DeviceInstance;
use App\App\Doctrine\Entity\Paragraph;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\App\Doctrine\Repository\ReportForm\ScreenRepository")
 * @ORM\Table(name="container")
 */
class Container
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=36, nullable=false)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\Paragraph")
     * @ORM\JoinColumn(name="paragraph_id", nullable=false)
     */
    private $paragraphId;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\ReportForm\Screen")
     * @ORM\JoinColumn(name="screen_id", nullable=false)
     */
    private $screenId;

    /**
     *  @ORM\Column(type="string", length=36, nullable=false)
     */
    private $title;

    /**
     *  @ORM\Column(type="integer", length=36, nullable=false)
     */
    private $position;

    /**
     *  @ORM\Column(type="integer", length=36, nullable=false)
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\DeviceInstance")
     * @ORM\JoinColumn(name="device_instance_id")
     */
    private $deviceInstanceId;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\ReportForm\Container")
     * @ORM\JoinColumn(name="parent")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="App\App\Doctrine\Entity\ReportForm\Container", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\Column(name="created_at", type="timestamp", nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\Column(name="modified_at", type="timestamp", nullable=false)
     */
    private $modifiedAt;

    /**
     * Container constructor.
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Container
     */
    public function setId(?string $id): Container
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Paragraph
     */
    public function getParagraphId(): Paragraph
    {
        return $this->paragraphId;
    }

    /**
     * @param Paragraph $paragraphId
     * @return Container
     */
    public function setParagraphId(Paragraph $paragraphId): Container
    {
        $this->paragraphId = $paragraphId;
        return $this;
    }

    /**
     * @return Screen
     */
    public function getScreenId(): Screen
    {
        return $this->screenId;
    }

    /**
     * @param Screen $screenId
     * @return Container
     */
    public function setScreenId(Screen $screenId): Container
    {
        $this->screenId = $screenId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Container
     */
    public function setTitle(string $title): Container
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return integer
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return Container
     */
    public function setPosition(int $position): Container
    {
        $this->position = $position;
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
     * @param int $level
     * @return Container
     */
    public function setLevel(int $level): Container
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return null | DeviceInstance
     */
    public function getDeviceInstanceId(): ?DeviceInstance
    {
        return $this->deviceInstanceId;
    }

    /**
     * @param DeviceInstance | null $deviceInstanceId
     * @return Container
     */
    public function setDeviceInstanceId(?DeviceInstance $deviceInstanceId): Container
    {
        $this->deviceInstanceId = $deviceInstanceId;
        return $this;
    }

    /**
     * @return null | Container
     */
    public function getParent(): ?Container
    {
        return $this->parent;
    }

    /**
     * @param Container $parent
     * @return Container
     */
    public function setParent(?Container $parent): Container
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren(): ArrayCollection
    {
        return $this->children;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return Container
     */
    public function setCreatedAt($createdAt): Container
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * @param mixed $modifiedAt
     * @return Container
     */
    public function setModifiedAt($modifiedAt): Container
    {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }
}
