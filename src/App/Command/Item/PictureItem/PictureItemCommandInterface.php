<?php


namespace App\App\Command\Item\PictureItem;

use App\App\Command\Item\Base\LabelInterface;
use App\App\Command\Item\Base\NFPArefInterface;
use App\App\Command\Item\Base\RememberedInterface;
use App\App\Command\Item\Base\RequiredInterface;

interface PictureItemCommandInterface extends
    LabelInterface,
    RememberedInterface,
    RequiredInterface,
    NFPArefInterface
{
}