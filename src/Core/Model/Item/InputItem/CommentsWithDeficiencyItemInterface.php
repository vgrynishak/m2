<?php

namespace App\Core\Model\Item\InputItem;

use App\Core\Model\Item\Base\DefaultAnswerInterface;
use App\Core\Model\Item\Base\LabelInterface;
use App\Core\Model\Item\Base\NFPAInterface;
use App\Core\Model\Item\Base\PlaceholderInterface;
use App\Core\Model\Item\Base\RememberInterface;
use App\Core\Model\Item\Base\RequireInterface;

interface CommentsWithDeficiencyItemInterface extends
    DefaultAnswerInterface,
    LabelInterface,
    NFPAInterface,
    RememberInterface,
    RequireInterface,
    PlaceholderInterface
{

}