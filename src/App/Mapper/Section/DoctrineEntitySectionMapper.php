<?php

namespace App\App\Mapper\Section;

use App\App\Doctrine\Entity\User as UserEntity;
use App\App\Mapper\User\DoctrineEntityUserMapperInterface;
use App\Core\Model\Exception\InvalidReportTemplateIdException;
use App\Core\Model\Exception\InvalidSectionIdException;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\Section\Section;
use App\App\Doctrine\Entity\Section as SectionEntity;
use App\Core\Model\Section\SectionId;
use App\Core\Model\Section\SectionInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;
use PhpCollection\CollectionInterface;

class DoctrineEntitySectionMapper implements DoctrineEntitySectionMapperInterface
{
    /** @var DoctrineEntityUserMapperInterface */
    private $doctrineEntityUserMapper;
    /** @var ParagraphQueryRepositoryInterface */
    private $paragraphQueryRepository;

    /**
     * DoctrineEntitySectionMapper constructor.
     * @param DoctrineEntityUserMapperInterface $userMapper
     * @param ParagraphQueryRepositoryInterface $paragraphQueryRepository
     */
    public function __construct(
        DoctrineEntityUserMapperInterface $userMapper,
        ParagraphQueryRepositoryInterface $paragraphQueryRepository
    ) {
        $this->doctrineEntityUserMapper = $userMapper;
        $this->paragraphQueryRepository = $paragraphQueryRepository;
    }

    /**
     * @param SectionEntity $sectionEntity
     * @return SectionInterface
     * @throws InvalidReportTemplateIdException
     * @throws InvalidSectionIdException
     */
    public function map(SectionEntity $sectionEntity): SectionInterface
    {
        /** @var SectionId $sectionId */
        $sectionId = new SectionId($sectionEntity->getId());
        /** @var Section $section */
        $section = new Section(
            $sectionId,
            new ReportTemplateId($sectionEntity->getReportTemplateVersion()->getId()),
            $sectionEntity->getTitle() ?? ''
        );
        /** @var int|null $sectionEntityPosition */
        $sectionEntityPosition = $sectionEntity->getPosition();

        if ($sectionEntityPosition) {
            $section->setPosition($sectionEntityPosition);
        }
        /** @var UserEntity $createdBy */
        $createdBy = $sectionEntity->getCreatedBy();
        if ($createdBy instanceof UserEntity) {
            $section->setCreatedBy($this->doctrineEntityUserMapper->map($createdBy));
        }

        /** @var UserEntity $modifiedBy */
        $modifiedBy = $sectionEntity->getModifiedBy();
        if ($modifiedBy instanceof UserEntity) {
            $section->setModifiedBy($this->doctrineEntityUserMapper->map($modifiedBy));
        }

        $section->setCreatedAt($sectionEntity->getCreatedAt());
        $section->setModifiedAt($sectionEntity->getUpdatedAt());
        $section->setPrintable($sectionEntity->getPrintable());

        if ($sectionEntity->getPosition()) {
            $section->setPosition($sectionEntity->getPosition());
        }
        if ($sectionEntity->getPrintable()) {
            $section->setPrintable($sectionEntity->getPrintable());
        }
        if ($sectionEntity->getCreatedAt()) {
            $section->setCreatedAt($sectionEntity->getCreatedAt());
        }
        if ($sectionEntity->getUpdatedAt()) {
            $section->setModifiedAt($sectionEntity->getUpdatedAt());
        }

        /** @var CollectionInterface|null $paragraphs */
        $paragraphs = $this->paragraphQueryRepository->findListBySectionId($sectionId);
        if ($paragraphs) {
            $section->setParagraphs($paragraphs);
        }

        return $section;
    }
}
