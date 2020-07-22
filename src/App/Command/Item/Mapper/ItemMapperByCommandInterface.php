<?php

namespace App\App\Command\Item\Mapper;

use App\App\Command\Item\BaseItemCommandInterface;
use App\App\Factory\Exception\FailMakeItemModel;
use App\Core\Model\Item\ItemInterface;

interface ItemMapperByCommandInterface
{
    /**
     * @param BaseItemCommandInterface $command
     * @return ItemInterface
     * @throws FailMakeItemModel
     */
    public function map(BaseItemCommandInterface $command): ItemInterface;
}