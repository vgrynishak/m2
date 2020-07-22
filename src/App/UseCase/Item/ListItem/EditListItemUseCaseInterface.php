<?php

namespace App\App\UseCase\Item\ListItem;

use App\App\Command\Item\BaseItemCommandInterface;
use App\App\Factory\Exception\FailMakeItemModel;
use App\Core\Model\Item\ItemInterface;

interface EditListItemUseCaseInterface
{
    /**
     * @param BaseItemCommandInterface $command
     * @return ItemInterface
     * @throws FailMakeItemModel
     */
    public function edit(BaseItemCommandInterface $command): ItemInterface;
}
