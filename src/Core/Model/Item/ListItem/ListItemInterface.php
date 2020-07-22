<?php

namespace App\Core\Model\Item\ListItem;

use App\Core\Model\Item\Base\DefaultAnswerInterface;
use App\Core\Model\Item\Base\LabelInterface;
use App\Core\Model\Item\Base\NFPAInterface;
use App\Core\Model\Item\Base\OptionInterface;
use App\Core\Model\Item\Base\RememberInterface;
use App\Core\Model\Item\Base\RequireInterface;

interface ListItemInterface extends
    DefaultAnswerInterface,
    LabelInterface,
    NFPAInterface,
    RememberInterface,
    RequireInterface,
    OptionInterface
{
}
