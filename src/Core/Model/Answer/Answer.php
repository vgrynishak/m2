<?php
namespace App\Core\Model\Answer;

use App\Core\Model\Answer\AnswerAssessment\AnswerAssessmentId;
use App\Core\Model\Item\ItemId;

class Answer implements AnswerInterface
{
    /** @var AnswerId */
    private $id;
    /** @var ItemId */
    private $itemId;
    /** @var AnswerAssessmentId */
    private $assessment;
    /** @var string */
    private $value;
    /** @var int */
    private $position;

    public function __construct(
        AnswerId $id,
        ItemId $itemId,
        AnswerAssessmentId $assessment
    ) {
        $this->id = $id;
        $this->itemId = $itemId;
        $this->assessment = $assessment;
    }

    /**
     * @return AnswerId
     */


    public function getId(): AnswerId
    {
        return $this->id;
    }

    /**
     * @return ItemId
     */
    public function getItemId(): ItemId
    {
        return $this->itemId;
    }

    /**
     * @return AnswerAssessmentId
     */
    public function getAssessment(): AnswerAssessmentId
    {
        return $this->assessment;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     */
    public function setValue(?string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return int|null
     */
    public function getPosition(): ?int
    {
        return  $this->position;
    }

    /**
     * @param int|null $position
     */
    public function setPosition(?int $position)
    {
        $this->position = $position;
    }
}
