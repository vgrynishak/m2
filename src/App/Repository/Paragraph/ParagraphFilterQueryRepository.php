<?php

namespace App\App\Repository\Paragraph;

use App\App\Doctrine\Entity\ParagraphFilter as ParagraphFilterORM;
use App\App\Doctrine\Repository\ParagraphFilterRepository;
use App\App\Mapper\Paragraph\ParagraphFilterEntityMapperInterface;
use App\Core\Model\Paragraph\ParagraphFilterId;
use App\Core\Model\Paragraph\ParagraphFilterInterface;
use App\Core\Repository\Paragraph\ParagraphFilterQueryRepositoryInterface;

class ParagraphFilterQueryRepository implements ParagraphFilterQueryRepositoryInterface
{
    /** @var ParagraphFilterRepository */
    private $paragraphFilterRepository;

    /** @var ParagraphFilterEntityMapperInterface */
    private $doctrineEntityParagraphFilterMapper;

    /**
     * ParagraphFilterQueryRepository constructor.
     *
     * @param ParagraphFilterRepository $paragraphFilterRepository
     * @param ParagraphFilterEntityMapperInterface $doctrineEntityParagraphFilterMapper
     */
    public function __construct(
        ParagraphFilterRepository $paragraphFilterRepository,
        ParagraphFilterEntityMapperInterface $doctrineEntityParagraphFilterMapper
    ) {
        $this->paragraphFilterRepository = $paragraphFilterRepository;
        $this->doctrineEntityParagraphFilterMapper = $doctrineEntityParagraphFilterMapper;
    }

    /**
     * @param ParagraphFilterId $id
     *
     * @return ParagraphFilterInterface
     */
    public function find(ParagraphFilterId $id): ?ParagraphFilterInterface
    {
        /** @var ParagraphFilterORM $paragraphFilterORM */
        $paragraphFilterORM = $this->paragraphFilterRepository->find($id->getValue());

        if (!$paragraphFilterORM instanceof ParagraphFilterORM) {
            return null;
        }

        return $this->doctrineEntityParagraphFilterMapper->map($paragraphFilterORM);
    }
}
