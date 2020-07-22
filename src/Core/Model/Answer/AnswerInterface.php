<?php

namespace App\Core\Model\Answer;

use App\Core\Model\Answer\AnswerAssessment\AnswerAssessmentId;
use App\Core\Model\Item\ItemId;

interface AnswerInterface
{
    public function getId(): AnswerId;

    public function getItemId(): ItemId;

    public function getAssessment(): AnswerAssessmentId;

    public function getValue(): ?string;

    public function setValue(?string $value);

    public function getPosition(): ?int;

    public function setPosition(?int $position);
}
