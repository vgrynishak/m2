<?php

namespace App\App\Handler\Device;

use App\Core\Model\Device\DeviceInterface;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\App\Query\Device\FindByIdQuery;

class FindByIdQueryHandler
{
    /** @var DeviceQueryRepositoryInterface  */
    protected $repository;

    /**
     * FindByIdQueryHandler constructor.
     * @param DeviceQueryRepositoryInterface $repository
     */
    public function __construct(DeviceQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param FindByIdQuery $query
     * @return DeviceInterface
     */
    public function __invoke(FindByIdQuery $query)
    {
        return $this->repository->find($query->getId());
    }
}
