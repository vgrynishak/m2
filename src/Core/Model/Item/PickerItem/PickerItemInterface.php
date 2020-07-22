<?php

namespace App\Core\Model\Item\PickerItem;

use App\Core\Model\Item\Base\LabelInterface;
use App\Core\Model\Item\Base\NFPAInterface;
use App\Core\Model\Item\Base\PlaceholderInterface;
use App\Core\Model\Item\Base\RememberInterface;
use App\Core\Model\Item\Base\RequireInterface;

interface PickerItemInterface extends
    LabelInterface,
    NFPAInterface,
    PlaceholderInterface,
    RememberInterface,
    RequireInterface
{

}
