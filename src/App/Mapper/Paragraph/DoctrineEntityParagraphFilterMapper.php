<?php

namespace App\App\Mapper\Paragraph;

use App\App\Doctrine\Entity\ParagraphFilter as ParagraphFilterEntity;
use App\Core\Model\Paragraph\ParagraphFilter;
use App\Core\Model\Paragraph\ParagraphFilterId;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class DoctrineEntityParagraphFilterMapper
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * DoctrineEntityParagraphMapper constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(UserQueryRepositoryInterface $userQueryRepository)
    {
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param ParagraphFilterEntity|null $paragraphEntity
     * @return ParagraphFilter|null
     * @throws \App\Core\Model\Exception\InvalidParagraphFilterIdException
     */
    public static function map(?ParagraphFilterEntity $paragraphEntity): ?ParagraphFilter
    {
        if (!$paragraphEntity) {
            return null;
        }

        $paragraphFilter = new ParagraphFilter(
            new ParagraphFilterId($paragraphEntity->getId()),
            $paragraphEntity->getName()
        );

        return $paragraphFilter;
    }
}
