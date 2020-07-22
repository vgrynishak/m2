<?php

namespace App\App\Handler\Service;

use App\App\Query\Service\FindByIdQuery;
use App\Core\Repository\Service\ServiceQueryRepositoryInterface;

class FindByIdQueryHandler
{
    /** @var ServiceQueryRepositoryInterface  */
    protected $repository;

    /**
     * FindByIdQueryHandler constructor.
     * @param ServiceQueryRepositoryInterface $repository
     */
    public function __construct(ServiceQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param FindByIdQuery $query
     * @return mixed
     */
    public function __invoke(FindByIdQuery $query)
    {
        return $this->repository->find($query->getId());
    }
}
