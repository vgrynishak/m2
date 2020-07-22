<?php

namespace App\App\UseCase\Device;

use App\App\Query\Device\FindByRootDeviceQueryInterface;
use App\App\Service\Device\RootDeviceGrouper;
use App\App\Service\Exception\RootDeviceGrouperException;
use App\App\Service\Exception\RootDeviceInvalidLevelException;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Exception\InvalidParagraphFilterIdException;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use PhpCollection\CollectionInterface;

class GetListByRootDeviceUseCase implements GetListByRootDeviceUseCaseInterface
{
    /** @var RootDeviceGrouper */
    private $deviceGrouper;
    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;

    public function __construct(
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        RootDeviceGrouper $deviceGrouper
    ) {
        $this->deviceQueryRepository = $deviceQueryRepository;
        $this->deviceGrouper = $deviceGrouper;
    }

    /**
     * @param FindByRootDeviceQueryInterface $query
     * @return CollectionInterface
     * @throws RootDeviceInvalidLevelException
     * @throws \Exception
     */
    public function getList(FindByRootDeviceQueryInterface $query): CollectionInterface
    {
        /** @var DeviceInterface $device */
        $device     = $this->deviceQueryRepository->find($query->getId());
        /** @var CollectionInterface $deviceTree */
        $deviceTree = $this->deviceQueryRepository->getTree();

        return $this->deviceGrouper->group($device, $deviceTree);
    }
}
