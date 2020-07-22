<?php

namespace App\App\UseCase\Item\PictureItem;

use App\App\Command\Item\BaseItemCommandInterface;
use App\App\Factory\Exception\FailMakeItemModel;
use App\Core\Model\Item\ItemInterface;

interface EditPictureItemUseCaseInterface
{
    /**
     * @param BaseItemCommandInterface $command
     * @return mixed
     * @throws FailMakeItemModel
     */
    public function edit(BaseItemCommandInterface $command): ItemInterface;
}
