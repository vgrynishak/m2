<?php

namespace App\App\Handler\Facility;

use App\App\Command\Facility\CreateFacilityCommand;
use App\Core\Model\Facility\Facility;
use App\Core\Repository\Facility\FacilityCommandRepositoryInterface;
use Exception;

class CreateFacilityCommandHandler
{
    /** @var FacilityCommandRepositoryInterface */
    protected $repository;

    /**
     * CreateFacilityCommandHandler constructor.
     * @param FacilityCommandRepositoryInterface $repository
     */
    public function __construct(FacilityCommandRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param CreateFacilityCommand $command
     * @return mixed
     * @throws Exception
     */
    public function __invoke(CreateFacilityCommand $command)
    {
        $facility = new Facility(
            $command->getName(),
            $command->getCreatedAt(),
            $command->getUpdatedAt()
        );

        return $this->repository->save($facility);
    }
}
