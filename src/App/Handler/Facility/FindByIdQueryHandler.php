<?php

namespace App\App\Handler\Facility;

use App\App\Query\Facility\FindByIdQuery;
use App\Core\Model\Facility\FacilityInterface;
use App\Core\Repository\Facility\FacilityQueryRepositoryInterface;

class FindByIdQueryHandler
{
    /** @var FacilityQueryRepositoryInterface  */
    protected $repository;

    /**
     * FacilityQueryHandler constructor.
     * @param FacilityQueryRepositoryInterface $repository
     */
    public function __construct(FacilityQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param FindByIdQuery $query
     * @return FacilityInterface
     */
    public function __invoke(FindByIdQuery $query)
    {
        return $this->repository->find($query->getId());
    }
}
