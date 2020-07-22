<?php

namespace App\Infrastructure\Adapter\Paragraph;

use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\ChildParagraphInterface;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\Paragraph\StyleTemplateId;
use App\Core\Model\Paragraph\WithDeviceParagraphInterface;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;
use App\Infrastructure\Adapter\DTO\Paragraph\Full as FullParagraphDTO;
use PhpCollection\CollectionInterface;

class Full
{
    /**
     * @param BaseParagraphInterface $paragraph
     * @return FullParagraphDTO
     */
    public static function adapt(BaseParagraphInterface $paragraph): FullParagraphDTO
    {
        /** @var FullParagraphDTO $fullParagraph */
        $fullParagraph = new FullParagraphDTO(
            $paragraph->getId()->getValue(),
            $paragraph->getUpdatedAt()->getTimestamp(),
            $paragraph->getCreatedAt()->getTimestamp()
        );

        $fullParagraph->setPrintable($paragraph->isPrintable());
        $fullParagraph->setPosition($paragraph->getPosition());

        /** @var BaseHeaderInterface $paragraphHeader */
        $paragraphHeader = $paragraph->getHeader();
        if ($paragraphHeader instanceof CustomHeaderInterface) {
            $fullParagraph->setHeaderValue($paragraphHeader->getValue());
        }

        if ($paragraph->getSectionId() instanceof SectionId) {
            $fullParagraph->setSectionId($paragraph->getSectionId()->getValue());
        }

        if ($paragraph->getStyleTemplateId() instanceof StyleTemplateId) {
            $fullParagraph->setStyleTemplateId($paragraph->getStyleTemplateId()->getValue());
        }
        if ($paragraph->getModifiedBy() instanceof UserInterface) {
            $fullParagraph->setModifiedById($paragraph->getModifiedBy()->getId());
        }
        if ($paragraph->getCreatedBy() instanceof UserInterface) {
            $fullParagraph->setCreatedById($paragraph->getCreatedBy()->getId());
        }

        if ($paragraph instanceof WithDeviceParagraphInterface) {
            $fullParagraph = self::fillForWithDevice($fullParagraph, $paragraph);
        }
        if ($paragraph instanceof ChildParagraphInterface) {
            $fullParagraph = self::fillForChildren($fullParagraph, $paragraph);
        }

        return $fullParagraph;
    }

    /**
     * @param CollectionInterface $paragraphsCollection
     * @return array
     */
    public static function adaptCollection(CollectionInterface $paragraphsCollection): array
    {
        /** @var FullParagraphDTO[] $paragraphs */
        $baseParagraphs = [];

        /** @var BaseParagraphInterface $paragraph */
        foreach ($paragraphsCollection as $paragraph) {
            $baseParagraphs[] = self::adapt($paragraph);
        }

        return $baseParagraphs;
    }

    /**
     * @param FullParagraphDTO $fullParagraph
     * @param WithDeviceParagraphInterface $paragraph
     * @return FullParagraphDTO
     */
    public static function fillForWithDevice(
        FullParagraphDTO $fullParagraph,
        WithDeviceParagraphInterface $paragraph
    ): FullParagraphDTO {
        $fullParagraph->setDeviceId($paragraph->getDevice()->getId()->getValue());
        $fullParagraph->setParagraphFilterId($paragraph->getFilter()->getId()->getValue());

        return $fullParagraph;
    }

    /**
     * @param FullParagraphDTO $fullParagraph
     * @param ChildParagraphInterface $paragraph
     * @return FullParagraphDTO
     */
    public static function fillForChildren(
        FullParagraphDTO $fullParagraph,
        ChildParagraphInterface $paragraph
    ): FullParagraphDTO {
        $fullParagraph->setLevel($paragraph->getLevel());
        $fullParagraph->setParentId($paragraph->getParent()->getValue());

        return $fullParagraph;
    }
}
