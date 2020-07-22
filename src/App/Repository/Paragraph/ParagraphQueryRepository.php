<?php


namespace App\App\Repository\Paragraph;

use App\App\Doctrine\Entity\Paragraph as ParagraphEntity;
use App\App\Mapper\Paragraph\DoctrineEntityParagraphMapperInterface;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\WithDeviceParagraphInterface;
use App\Core\Model\Section\SectionId;
use App\Core\Model\Paragraph\ParagraphId;
use Doctrine\ORM\NoResultException;
use PhpCollection\CollectionInterface;
use PhpCollection\Set;
use Doctrine\ORM\EntityManagerInterface;
use App\App\Doctrine\Repository\ParagraphRepository as ParagraphRepository;
use Doctrine\ORM\NonUniqueResultException;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;

class ParagraphQueryRepository implements ParagraphQueryRepositoryInterface
{
    /** @var EntityManagerInterface */
    protected $entityManager;
    /** @var ParagraphRepository */
    private $paragraphRepository;
    /** @var DoctrineEntityParagraphMapperInterface */
    private $doctrineEntityParagraphMapper;

    /**
     * ParagraphQueryRepository constructor.
     * @param EntityManagerInterface $entityManager
     * @param DoctrineEntityParagraphMapperInterface $mapper
     * @param ParagraphRepository $paragraphRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        DoctrineEntityParagraphMapperInterface $mapper,
        ParagraphRepository $paragraphRepository
    ) {
        $this->entityManager = $entityManager;
        $this->doctrineEntityParagraphMapper = $mapper;
        $this->paragraphRepository = $paragraphRepository;
    }

    /**
     * @param SectionId $sectionId
     * @return CollectionInterface|null
     */
    public function findListBySectionId(SectionId $sectionId): ?CollectionInterface
    {
        /** @var ParagraphEntity[] $paragraphsEntity */
        $paragraphsEntity = $this->paragraphRepository->findRootListBySectionId($sectionId);
        if (!$paragraphsEntity) {
            return null;
        }

        /** @var BaseParagraphInterface[] $paragraphs */
        $paragraphs = [];
        /** @var ParagraphEntity $paragraphEntity */
        foreach ($paragraphsEntity as $paragraphEntity) {
            /** @var BaseParagraphInterface $paragraph */
            $paragraph = $this->doctrineEntityParagraphMapper->map($paragraphEntity);
            /** @var CollectionInterface $children */
            $children = $this->findChildrenListByParentId($paragraph->getId());

            if ($children) {
                $paragraph->setChildren($children);
            }

            $paragraphs[] = $paragraph;
        }

        return new Set($paragraphs);
    }

    /**
     * @param ParagraphId $parentId
     * @return CollectionInterface|null
     */
    public function findChildrenListByParentId(ParagraphId $parentId): ?CollectionInterface
    {
        /** @var ParagraphEntity[] $paragraphsEntity */
        $paragraphsEntity = $this->paragraphRepository->getChildrenListByParentId($parentId);

        if (!$paragraphsEntity) {
            return null;
        }

        /** @var BaseParagraphInterface[] $paragraphs */
        $paragraphs = [];
        /** @var ParagraphEntity $paragraphEntity */
        foreach ($paragraphsEntity as $paragraphEntity) {
            $paragraphs[] = $this->doctrineEntityParagraphMapper->map($paragraphEntity);
        }

        /** @var BaseParagraphInterface $child */
        foreach ($paragraphs as $child) {
            /** @var CollectionInterface $nestedChildren */
            $nestedChildren = $this->findChildrenListByParentId($child->getId());

            if ($nestedChildren) {
                $child->setChildren($nestedChildren);
            }
        }

        return new Set($paragraphs);
    }

    /**
     * @param ParagraphId $id
     * @return BaseParagraphInterface|null
     */
    public function find(ParagraphId $id): ?BaseParagraphInterface
    {
        /** @var ParagraphEntity $paragraphEntity */
        $paragraphEntity = $this->paragraphRepository->find($id->getValue());

        if (!$paragraphEntity instanceof ParagraphEntity) {
            return null;
        }

        /** @var BaseParagraphInterface $paragraph */
        $paragraph = $this->doctrineEntityParagraphMapper->map($paragraphEntity);
        /** @var CollectionInterface $children */
        $children = $this->findChildrenListByParentId($paragraph->getId());

        if ($children && ($paragraph instanceof WithDeviceParagraphInterface)) {
            $paragraph->setChildren($children);
        }

        return $paragraph;
    }

    /**
     * @param SectionId $id
     * @return int
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getMaxPositionForRoot(SectionId $id): int
    {
        return (int)$this->paragraphRepository->getMaxPositionForRoot($id);
    }

    /**
     * @param ParagraphId $id
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getMaxPositionForChild(ParagraphId $id): int
    {
        return (int)$this->paragraphRepository->getMaxPositionForChild($id);
    }

    /**
     * @param BaseParagraphInterface $paragraph
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getMaxPosition(BaseParagraphInterface $paragraph): int
    {
        return (int)$this->paragraphRepository->getMaxPosition($paragraph);
    }
}
