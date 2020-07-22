<?php


namespace App\App\Command\Item\InputItem;


use App\App\Command\Item\Base\DefaultAnswerInterface;
use App\App\Command\Item\Base\LabelInterface;
use App\App\Command\Item\Base\NFPArefInterface;
use App\App\Command\Item\Base\PlaceholderInterface;
use App\App\Command\Item\Base\RememberedInterface;
use App\App\Command\Item\Base\RequiredInterface;

interface InputItemCommandInterface extends
    LabelInterface,
    RememberedInterface,
    RequiredInterface,
    PlaceholderInterface,
    NFPArefInterface,
    DefaultAnswerInterface
{

}