<?php

namespace App\App\Repository\Section;

use App\App\Doctrine\Repository\SectionRepository;
use App\App\Mapper\Section\DoctrineEntitySectionMapperInterface;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\Section\SectionId;
use App\Core\Model\Section\SectionInterface;
use App\Core\Repository\Section\SectionQueryRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\App\Doctrine\Entity\Section as SectionEntity;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use PhpCollection\CollectionInterface;
use App\App\Doctrine\Entity\Section as SectionORM;
use PhpCollection\Set;

class SectionQueryRepository implements SectionQueryRepositoryInterface
{
    /** @var EntityManagerInterface */
    protected $entityManager;
    /** @var DoctrineEntitySectionMapperInterface */
    private $entitySectionMapper;

    /**
     * SectionQueryRepository constructor.
     * @param EntityManagerInterface $entityManager
     * @param DoctrineEntitySectionMapperInterface $entitySectionMapper
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        DoctrineEntitySectionMapperInterface $entitySectionMapper
    ) {
        $this->entityManager = $entityManager;
        $this->entitySectionMapper = $entitySectionMapper;
    }

    /**
     * @param SectionId $id
     * @return SectionInterface|null
     */
    public function find(SectionId $id): ?SectionInterface
    {
        /** @var SectionRepository $sectionRepository */
        $sectionRepository = $this->entityManager->getRepository('App:Section');
        /** @var SectionEntity $sectionEntity */
        $sectionEntity = $sectionRepository->find($id->getValue());

        if (!$sectionEntity instanceof SectionEntity) {
            return null;
        }

        return $this->entitySectionMapper->map($sectionEntity);
    }

    /**
     * @param ReportTemplateId $id
     * @return int
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getMaxPosition(ReportTemplateId $id): int
    {
        $sectionRepository = $this->entityManager->getRepository('App:Section');
        $position = (int)$sectionRepository->getMaxPosition($id);
        return $position;
    }

    /**
     * @param string $reportTemplateVersionId
     * @return CollectionInterface|null
     */
    public function findListByReportTemplateVersionId(string $reportTemplateVersionId): ?CollectionInterface
    {
        /** @var SectionRepository $sectionRepository */
        $sectionRepository = $this->entityManager->getRepository('App:Section');
        /** @var SectionORM[] $sectionsORM */
        $sectionsORM = $sectionRepository->findListByReportTemplateVersionId($reportTemplateVersionId);
        if (!$sectionsORM) {
            return null;
        }

        /** @var SectionInterface[] $sectionModel */
        $sectionModel = [];

        /** @var SectionORM $sectionORM */
        foreach ($sectionsORM as $sectionORM) {
            $sectionModel[] = $this->entitySectionMapper->map($sectionORM);
        }

        return new Set($sectionModel);
    }
}
