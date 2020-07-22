<?php

namespace App\App\UseCase\Item\DeviceInformationItem;

use App\App\Command\Item\BaseItemCommandInterface;
use App\App\Factory\Exception\FailMakeItemModel;
use App\Core\Model\Item\ItemInterface;

interface EditDeviceInformationItemUseCaseInterface
{
    /**
     * @param BaseItemCommandInterface $command
     * @return mixed
     * @throws FailMakeItemModel
     */
    public function edit(BaseItemCommandInterface $command): ItemInterface;
}
