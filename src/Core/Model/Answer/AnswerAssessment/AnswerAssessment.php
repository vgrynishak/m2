<?php
namespace App\Core\Model\Answer\AnswerAssessment;

class AnswerAssessment implements AnswerAssessmentInterface
{
    public const NEGATIVE   = 'negative';
    public const NONE       = 'none';

    /** @var AnswerAssessmentId */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $description;

    public function __construct(
        AnswerAssessmentId $id,
        string $name
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return AnswerAssessmentId
     */
    public function getId(): AnswerAssessmentId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
