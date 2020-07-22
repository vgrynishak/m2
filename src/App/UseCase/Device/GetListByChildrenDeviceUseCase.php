<?php

namespace App\App\UseCase\Device;

use App\App\Query\Device\FindByChildrenDeviceQuery;
use App\App\Query\Device\FindByChildrenDeviceQueryInterface;
use App\App\Service\Device\ChildrenDeviceGrouper;
use App\App\Service\Exception\ChildrenDeviceGrouperException;
use App\App\Service\Exception\ChildrenDeviceInvalidLevelException;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Exception\InvalidGroupIdException;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use PhpCollection\CollectionInterface;

class GetListByChildrenDeviceUseCase implements GetListByChildrenDeviceUseCaseInterface
{
    /** @var ChildrenDeviceGrouper */
    private $deviceGrouper;
    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;

    public function __construct(
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        ChildrenDeviceGrouper $deviceGrouper
    ) {
        $this->deviceQueryRepository = $deviceQueryRepository;
        $this->deviceGrouper = $deviceGrouper;
    }

    /**
     * @param FindByChildrenDeviceQueryInterface $query
     * @return CollectionInterface
     * @throws ChildrenDeviceInvalidLevelException
     * @throws \Exception
     */
    public function getList(FindByChildrenDeviceQueryInterface $query): CollectionInterface
    {
        /** @var DeviceInterface $device */
        $device     = $this->deviceQueryRepository->find($query->getId());
        /** @var CollectionInterface $deviceTree */
        $deviceTree = $this->deviceQueryRepository->getTree();

        return $this->deviceGrouper->group($device, $deviceTree, $query->getGroupId());
    }
}
