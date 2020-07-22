<?php

namespace App\App\Repository\DeviceInstance;

use App\App\Doctrine\Entity\DeviceInstance as DeviceInstanceEntity;
use App\App\Doctrine\Mapper\DeviceInstance\DeviceInstanceModelInterface;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;
use App\Core\Repository\DeviceInstance\DeviceInstanceCommandRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DeviceInstanceCommandRepository implements DeviceInstanceCommandRepositoryInterface
{
    /** @var DeviceInstanceModelInterface */
    private $deviceInstanceModelMapper;
    /** @var EntityManagerInterface  */
    private $entityManager;

    /**
     * DeviceInstanceCommandRepository constructor.
     * @param DeviceInstanceModelInterface $deviceInstanceModelMapper
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        DeviceInstanceModelInterface $deviceInstanceModelMapper,
        EntityManagerInterface $entityManager
    ) {
        $this->deviceInstanceModelMapper = $deviceInstanceModelMapper;
        $this->entityManager = $entityManager;
    }

    /**
     * @param DeviceInstanceInterface $deviceInstance
     */
    public function create(DeviceInstanceInterface $deviceInstance): void
    {
        /** @var DeviceInstanceEntity $deviceInstanceEntity */
        $deviceInstanceEntity = $this->deviceInstanceModelMapper->mapNew($deviceInstance);

        $this->entityManager->persist($deviceInstanceEntity);
        $this->entityManager->flush();
    }
}
