<?php

namespace App\App\Repository\Facility;

use App\App\Doctrine\Entity\Facility as FacilityEntity;
use App\App\Doctrine\Repository\FacilityRepository;
use App\Core\Model\Facility\Facility;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Facility\FacilityInterface;
use App\Core\Repository\Facility\FacilityQueryRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class FacilityQueryRepository implements FacilityQueryRepositoryInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * FacilityQueryRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param FacilityId $id
     * @return FacilityInterface|null
     * @throws Exception
     */
    public function find(FacilityId $id): ?FacilityInterface
    {
        /** @var FacilityRepository $facilityRepository */
        $facilityRepository = $this->entityManager->getRepository('App:Facility');
        /** @var FacilityEntity $facilityEntity */
        $facilityEntity = $facilityRepository->find($id->getValue());

        if (!$facilityEntity instanceof FacilityEntity) {
            return null;
        }

        // TODO Временное решение для проверки работы тестов

        /** @var FacilityInterface $facility */
        $facility = new Facility(
            new FacilityId($facilityEntity->getId()),
            $facilityEntity->getName()
        );

        $facility->setCreatedAt($facilityEntity->getCreatedAt());
        $facility->setUpdatedAt($facilityEntity->getUpdatedAt());

        return $facility;
    }
}
