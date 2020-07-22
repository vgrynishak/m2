<?php

namespace App\App\Command\Item\PickerItem;

use App\App\Command\Item\Base\LabelInterface;
use App\App\Command\Item\Base\NFPArefInterface;
use App\App\Command\Item\Base\PlaceholderInterface;
use App\App\Command\Item\Base\RememberedInterface;
use App\App\Command\Item\Base\RequiredInterface;

interface PickerItemCommandInterface extends
    LabelInterface,
    PlaceholderInterface,
    NFPArefInterface,
    RememberedInterface,
    RequiredInterface
{

}
