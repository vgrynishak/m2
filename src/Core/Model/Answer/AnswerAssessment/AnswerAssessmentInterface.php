<?php


namespace App\Core\Model\Answer\AnswerAssessment;


interface AnswerAssessmentInterface
{
    public function getId(): AnswerAssessmentId;

    public function getName(): string;

    public function setDescription(string $description);

    public function getDescription(): string;
}