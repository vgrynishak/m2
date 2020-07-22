<?php

namespace App\App\Repository\Paragraph;

use App\App\Doctrine\Entity\HeaderType as HeaderTypeEntity;
use App\App\Doctrine\Entity\Paragraph as ParagraphEntity;
use App\App\Doctrine\Repository\ParagraphRepository;
use App\App\Mapper\Paragraph\DoctrineEntityHeaderMapperInterface;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Repository\Paragraph\HeaderQueryRepositoryInterface;

class HeaderQueryRepository implements HeaderQueryRepositoryInterface
{
    /** @var ParagraphRepository */
    private $paragraphRepository;
    /** @var DoctrineEntityHeaderMapperInterface */
    private $doctrineEntityHeaderMapper;

    /**
     * HeaderQueryRepository constructor.
     * @param ParagraphRepository $paragraphRepository
     * @param DoctrineEntityHeaderMapperInterface $doctrineEntityHeaderMapper
     */
    public function __construct(
        ParagraphRepository $paragraphRepository,
        DoctrineEntityHeaderMapperInterface $doctrineEntityHeaderMapper
    ) {
        $this->paragraphRepository = $paragraphRepository;
        $this->doctrineEntityHeaderMapper = $doctrineEntityHeaderMapper;
    }

    /**
     * @param ParagraphId $paragraphId
     * @return BaseHeaderInterface|null
     */
    public function findByParagraphId(ParagraphId $paragraphId): ?BaseHeaderInterface
    {
        /** @var ParagraphEntity $paragraphEntity */
        $paragraphEntity = $this->paragraphRepository->find($paragraphId->getValue());

        if (!$paragraphEntity instanceof ParagraphEntity) {
            return null;
        }
        if (!$paragraphEntity->getHeaderType() instanceof HeaderTypeEntity) {
            return null;
        }

        return $this->doctrineEntityHeaderMapper->map($paragraphEntity->getHeaderType(), $paragraphEntity->getTitle());
    }
}
