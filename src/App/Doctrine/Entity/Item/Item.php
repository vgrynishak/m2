<?php

namespace App\App\Doctrine\Entity\Item;

use App\App\Doctrine\Entity\Answer;
use App\App\Doctrine\Entity\Paragraph;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\UniqueConstraint;
use PhpCollection\CollectionInterface;

/**
 * @ORM\Entity(repositoryClass="App\App\Doctrine\Repository\Item\ItemRepository")
 * @ORM\Table(name="item",uniqueConstraints={@UniqueConstraint(name="uuid_idx", columns={"id"})})
 */
class Item
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
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\Item\ItemType")
     * @ORM\JoinColumn(name="item_type_id", nullable=false)
     */
    private $itemTypeId;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $label;

    /**
     * @ORM\OneToOne(targetEntity="App\App\Doctrine\Entity\Answer")
     * @ORM\JoinColumn(name="default_answer_id", nullable=true)
     */
    private $defaultAnswer;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\Item\InfoSource")
     * @ORM\JoinColumn(name="info_source_id", nullable=true)
     */
    private $infoSource;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $remembered;

    /**
     * @ORM\Column(type="string", length=36, nullable=true)
     */
    private $placeholder;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $required;

    /**
     * @ORM\Column(type="string", name="nfpa_ref", length=36, nullable=true)
     */
    private $NFPARef;

    /**
     * @ORM\Column(type="boolean", options={"default" : true})
     */
    private $printable = true;

    /**
     * @ORM\Column(type="timestamp")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="timestamp")
     */
    private $updatedAt;

    /**
     *
     * @OneToMany(targetEntity="App\App\Doctrine\Entity\Answer", mappedBy="item", cascade={"remove"})
     */
    private $answers;

    /**
     * Item constructor.
     */
    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Item
     */
    public function setId(string $id): Item
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Paragraph
     */
    public function getParagraphId() : Paragraph
    {
        return $this->paragraphId;
    }

    /**
     * @param Paragraph $paragraphId
     * @return Item
     */
    public function setParagraphId(Paragraph $paragraphId): Item
    {
        $this->paragraphId = $paragraphId;

        return $this;
    }

    /**
     * @return ItemType
     */
    public function getItemTypeId(): ItemType
    {
        return $this->itemTypeId;
    }

    /**
     * @param ItemType $itemTypeId
     * @return Item
     */
    public function setItemTypeId(ItemType $itemTypeId): Item
    {
        $this->itemTypeId = $itemTypeId;

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
     * @return Item
     */
    public function setPosition(int $position): Item
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLabel() :?string
    {
        return $this->label;
    }

    /**
     * @param string|null $label
     * @return Item
     */
    public function setLabel(?string $label): Item
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Answer|null
     */
    public function getDefaultAnswer(): ?Answer
    {
        return $this->defaultAnswer;
    }

    /**
     * @param Answer|null $defaultAnswer
     * @return Item
     */
    public function setDefaultAnswer(?Answer $defaultAnswer): Item
    {
        $this->defaultAnswer = $defaultAnswer;

        return $this;
    }

    /**
     * @return InfoSource|null
     */
    public function getInfoSource(): ?InfoSource
    {
        return $this->infoSource;
    }

    /**
     * @param InfoSource|null $infoSource
     * @return Item
     */
    public function setInfoSource(?InfoSource $infoSource): Item
    {
        $this->infoSource = $infoSource;

        return $this;
    }

    /**
     * @return null|bool
     */
    public function getRemembered(): ?bool
    {
        return $this->remembered;
    }

    /**
     * @param bool|null $remembered
     * @return Item
     */
    public function setRemembered(?bool $remembered): Item
    {
        $this->remembered = $remembered;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    /**
     * @param string|null $placeholder
     * @return Item
     */
    public function setPlaceholder(?string $placeholder): Item
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * @return null|bool
     */
    public function getRequired(): ?bool
    {
        return $this->required;
    }

    /**
     * @param null|bool $required
     * @return Item
     */
    public function setRequired(?bool $required): Item
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNFPARef(): ?string
    {
        return $this->NFPARef;
    }

    /**
     * @param string|null $NFPARef
     * @return Item
     */
    public function setNFPARef(?string $NFPARef): Item
    {
        $this->NFPARef = $NFPARef;

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
     * @param mixed $createdAt
     * @return Item
     */
    public function setCreatedAt($createdAt): Item
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
     * @param mixed $updatedAt
     * @return Item
     */
    public function setUpdatedAt($updatedAt): Item
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrintable()
    {
        return $this->printable;
    }

    /**
     * @param mixed $printable
     * @return Item
     */
    public function setPrintable($printable): Item
    {
        $this->printable = $printable;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param CollectionInterface $answers
     * @return $this
     */
    public function addAnswers(CollectionInterface $answers): self
    {
        foreach ($answers as $answer) {
            $this->answers[] = $answer;
        }

        return $this;
    }
}
