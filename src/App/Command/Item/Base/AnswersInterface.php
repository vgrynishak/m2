<?php

namespace App\App\Command\Item\Base;

use PhpCollection\CollectionInterface;

interface AnswersInterface
{
    public function setAnswers(CollectionInterface $answers);

    public function getAnswers(): CollectionInterface;
}
