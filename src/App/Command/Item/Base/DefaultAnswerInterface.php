<?php

namespace App\App\Command\Item\Base;

use App\Core\Model\Answer\Answer;

interface DefaultAnswerInterface
{
    public function setDefaultAnswer(?Answer $default);

    public function getDefaultAnswer(): ?Answer;
}
