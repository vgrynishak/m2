<?php

namespace App\App\Doctrine\Entity;

use App\App\Doctrine\Entity\Item\AnswerAssessment;
use App\App\Doctrine\Entity\Item\Item;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\App\Doctrine\Repository\AnswerRepository")
 * @ORM\Table(name="answer")
 */
class Answer
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=36, nullable=false)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\Item\Item")
     * @ORM\JoinColumn(nullable=false)
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\Item\AnswerAssessment")
     * @ORM\JoinColumn(nullable=false)
     */
    private $assessment;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $position;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $text;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Answer
     */
    public function setId(string $id): Answer
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Item
     */
    public function getItem(): Item
    {
        return $this->item;
    }

    /**
     * @param Item $item
     *
     * @return Answer
     */
    public function setItem(Item $item): Answer
    {
        $this->item = $item;
        return $this;
    }

    /**
     * @return AnswerAssessment
     */
    public function getAssessment(): AnswerAssessment
    {
        return $this->assessment;
    }

    /**
     * @param AnswerAssessment $assessment
     * @return Answer
     */
    public function setAssessment(AnswerAssessment $assessment): Answer
    {
        $this->assessment = $assessment;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Answer
     */
    public function setText(string $text): Answer
    {
        $this->text = $text;

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
     * @return Answer
     */
    public function setPosition($position): Answer
    {
        $this->position = $position;

        return $this;
    }
}
