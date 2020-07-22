<?php

namespace App\Infrastructure\Adapter\Section;

use App\Core\Model\Section\SectionInterface;
use App\Core\Model\User\UserInterface;
use App\Infrastructure\Adapter\DTO\Section\Full as FullSectionDTO;
use DateTime;
use PhpCollection\CollectionInterface;
use App\Infrastructure\Adapter\Paragraph\Full as FullParagraphAdapter;
use App\Infrastructure\Adapter\DTO\Paragraph\Full as FullParagraphDTO;

class Full
{
    /**
     * @param SectionInterface $section
     * @return FullSectionDTO
     */
    public static function adapt(SectionInterface $section): FullSectionDTO
    {
        /** @var FullSectionDTO $fullSection */
        $fullSection = new FullSectionDTO(
            $section->getId()->getValue(),
            $section->getReportTemplateId()->getValue(),
            $section->getTitle()
        );
        $fullSection->setPosition($section->getPosition());
        $fullSection->setPrintable($section->isPrintable());

        if ($section->getCreatedBy() instanceof UserInterface) {
            $fullSection->setCreatedById($section->getCreatedBy()->getId());
        }
        if ($section->getModifiedBy() instanceof UserInterface) {
            $fullSection->setModifiedById($section->getModifiedBy()->getId());
        }
        if ($section->getModifiedAt() instanceof DateTime) {
            $fullSection->setModifiedAt($section->getModifiedAt()->getTimestamp());
        }
        if ($section->getCreatedAt() instanceof DateTime) {
            $fullSection->setCreatedAt($section->getCreatedAt()->getTimestamp());
        }
        if ($section->getParagraphs() instanceof CollectionInterface) {
            /** @var FullParagraphDTO[] $paragraphs */
            $paragraphs = FullParagraphAdapter::adaptCollection($section->getParagraphs());
            $fullSection->setParagraphs($paragraphs);
        }

        return $fullSection;
    }

    /**
     * @param CollectionInterface $sectionCollection
     * @return array
     */
    public static function adaptCollection(CollectionInterface $sectionCollection): array
    {
        /** @var FullSectionDTO[] $sections */
        $sections = [];

        /** @var SectionInterface $section */
        foreach ($sectionCollection as $section) {
            $sections[] = self::adapt($section);
        }

        return $sections;
    }
}
