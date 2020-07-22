<?php

namespace App\App\UseCase\Item\InputItem;

use App\App\Command\Item\BaseItemCommandInterface;
use App\App\Factory\Exception\FailMakeItemModel;
use App\Core\Model\Item\ItemInterface;

interface EditInputItemUseCaseInterface
{
    /**
     * @param BaseItemCommandInterface $command
     * @return mixed
     * @throws FailMakeItemModel
     */
    public function edit(BaseItemCommandInterface $command): ItemInterface;
}
