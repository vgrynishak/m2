<?php

namespace App\Core\Model\Item\Base;

use App\Core\Model\Answer\AnswerInterface;

interface DefaultAnswerInterface
{
    public function setDefaultAnswer(?AnswerInterface $default);

    public function getDefaultAnswer(): ?AnswerInterface;
}