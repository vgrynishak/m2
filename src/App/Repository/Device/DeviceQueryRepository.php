<?php

namespace App\App\Repository\Device;

use App\App\Doctrine\Repository\DeviceRepository as DeviceEntityRepository;
use App\App\Mapper\Device\DoctrineEntityDeviceMapperInterface;
use App\App\Repository\Device\Service\DeviceTreeBuilder;
use App\App\Repository\Device\Service\DeviceTreeBuilderInterface;
use App\App\Repository\Exception\NonDevices;
use App\App\Service\Exception\ChildrenDeviceInvalidLevelException;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidDivisionIdException;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\App\Doctrine\Entity\Device as DeviceEntity;
use PhpCollection\CollectionInterface;

class DeviceQueryRepository implements DeviceQueryRepositoryInterface
{
    /** @var DeviceEntityRepository */
    protected $deviceEntityRepository;
    /** @var DoctrineEntityDeviceMapperInterface */
    private $mapper;
    /** @var DeviceTreeBuilder */
    private $deviceTreeBuilder;

    /**
     * DeviceQueryRepository constructor.
     * @param DeviceEntityRepository $deviceEntityRepository
     * @param DoctrineEntityDeviceMapperInterface $mapper
     * @param DeviceTreeBuilderInterface $deviceTreeBuilder
     */
    public function __construct(
        DeviceEntityRepository $deviceEntityRepository,
        DoctrineEntityDeviceMapperInterface $mapper,
        DeviceTreeBuilderInterface $deviceTreeBuilder
    ) {
        $this->deviceEntityRepository = $deviceEntityRepository;
        $this->mapper = $mapper;
        $this->deviceTreeBuilder = $deviceTreeBuilder;
    }

    /**
     * @param DeviceId $deviceId
     * @return DeviceInterface|null
     */
    public function find(DeviceId $deviceId): ?DeviceInterface
    {
        /** @var DeviceEntity $deviceEntity */
        $deviceEntity = $this->deviceEntityRepository->find($deviceId->getValue());

        if (!$deviceEntity instanceof DeviceEntity) {
            return null;
        }

        return $this->mapper->map($deviceEntity);
    }

    /**
     * @return CollectionInterface | null
     */
    public function getTree(): ?CollectionInterface
    {
        $deviceORMArray = $this->deviceEntityRepository->getAllDevicesOrderedByNameAsc();

        try {
            return $this->deviceTreeBuilder->build($deviceORMArray);
        } catch (NonDevices |
            ChildrenDeviceInvalidLevelException |
            InvalidDeviceIdException |
            InvalidDivisionIdException $e) {
            return null;
        }
    }
}
