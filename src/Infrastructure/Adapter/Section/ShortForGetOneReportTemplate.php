<?php

namespace App\Infrastructure\Adapter\Section;

use App\Core\Model\Section\SectionInterface;
use App\Infrastructure\Adapter\DTO\Section\ShortForGetOneReportTemplate as ShortSectionForOneRTDTO;
use PhpCollection\CollectionInterface;
use App\Infrastructure\Adapter\Paragraph\ShortForGetOneReportTemplate as ShortParagraphAdapter;
use App\Infrastructure\Adapter\DTO\Paragraph\Full as FullParagraphDTO;

class ShortForGetOneReportTemplate
{
    /**
     * @param SectionInterface $section
     * @return ShortSectionForOneRTDTO
     */
    public static function adapt(SectionInterface $section): ShortSectionForOneRTDTO
    {
        /** @var ShortSectionForOneRTDTO $shortSection */
        $shortSection = new ShortSectionForOneRTDTO(
            $section->getId()->getValue(),
            $section->getTitle()
        );
        /** @var int | null $position */
        $position = $section->getPosition();

        if ($position) {
            $shortSection->setPosition($position);
        }
        if ($section->getParagraphs() instanceof CollectionInterface) {
            /** @var FullParagraphDTO[] $paragraphs */
            $paragraphs = ShortParagraphAdapter::adaptCollection($section->getParagraphs());
            $shortSection->setParagraphs($paragraphs);
        }

        return $shortSection;
    }

    /**
     * @param CollectionInterface $sectionCollection
     * @return array
     */
    public static function adaptCollection(CollectionInterface $sectionCollection): array
    {
        /** @var ShortSectionForOneRTDTO[] $sections */
        $sections = [];

        /** @var SectionInterface $section */
        foreach ($sectionCollection as $section) {
            $sections[] = self::adapt($section);
        }

        return $sections;
    }
}
