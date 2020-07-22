<?php

namespace App\App\Repository\Division;

use App\App\Doctrine\Repository\DivisionRepository;
use App\App\Mapper\Division\DoctrineEntityDivisionMapper;
use App\Core\Model\Division\Division;
use App\Core\Model\Division\DivisionId;
use App\Core\Model\Exception\InvalidDivisionIdException;
use App\Core\Repository\Division\DivisionQueryRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\App\Doctrine\Entity\Division as DivisionORM;

class DivisionQueryRepository implements DivisionQueryRepositoryInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var DoctrineEntityDivisionMapper */
    private $mapper;

    /**
     * DivisionQueryRepository constructor.
     * @param EntityManagerInterface $entityManager
     * @param DoctrineEntityDivisionMapper $mapper
     */
    public function __construct(EntityManagerInterface $entityManager, DoctrineEntityDivisionMapper $mapper)
    {
        $this->entityManager = $entityManager;
        $this->mapper = $mapper;
    }

    /**
     * @param DivisionId $id
     * @return Division|null
     * @throws InvalidDivisionIdException
     */
    public function find(DivisionId $id): ?Division
    {
        /** @var DivisionRepository $deviceRepository */
        $divisionRepository = $this->entityManager->getRepository('App:Division');
        /** @var DivisionORM $deviceORM */
        $divisionORM = $divisionRepository->find($id->getValue());

        if (!$divisionORM instanceof DivisionORM) {
            return null;
        }

        return $this->mapper->map($divisionORM);
    }
}
