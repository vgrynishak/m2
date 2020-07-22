<?php

namespace App\Infrastructure\Adapter\Paragraph;

use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\ChildParagraphInterface;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\Paragraph\WithDeviceParagraphInterface;
use App\Infrastructure\Adapter\DTO\Paragraph\Full as FullParagraphDTO;
use App\Infrastructure\Adapter\DTO\Paragraph\ShortForGetOneReportTemplate as ShortParagraphDTO;
use App\Infrastructure\Adapter\DTO\Device\ShortForGetOneReportTemplate as ShortDeviceDTO;
use App\Infrastructure\Adapter\Device\ShortForGetOneReportTemplate as ShortDeviceAdapter;
use App\Infrastructure\Adapter\Paragraph\Filter\Full as FullParagraphFilterAdapter;
use PhpCollection\CollectionInterface;
use App\Infrastructure\Adapter\DTO\Paragraph\Filter\Full as FullParagraphFilterDTO;
use App\Infrastructure\Adapter\Item\Full as ItemAdapter;

class ShortForGetOneReportTemplate
{
    /**
     * @param BaseParagraphInterface $paragraph
     * @return ShortParagraphDTO
     */
    public static function adapt(BaseParagraphInterface $paragraph): ShortParagraphDTO
    {
        /** @var ShortParagraphDTO $shortParagraphDTO */
        $shortParagraphDTO = new ShortParagraphDTO(
            $paragraph->getId()->getValue()
        );
        $shortParagraphDTO->setPosition($paragraph->getPosition());
        /** @var BaseHeaderInterface $paragraphHeader */
        $paragraphHeader = $paragraph->getHeader();

        if ($paragraphHeader instanceof CustomHeaderInterface) {
            $shortParagraphDTO->setHeaderValue($paragraphHeader->getValue());
        }

        if ($paragraph->getItems() && $paragraph->getItems()->count()) {
            $shortParagraphDTO->setItems(ItemAdapter::adaptCollection($paragraph->getItems()));
        }

        if ($paragraph instanceof ChildParagraphInterface) {
            $shortParagraphDTO->setParentId($paragraph->getParent()->getValue());
            $shortParagraphDTO->setLevel($paragraph->getLevel());
        }

        if ($paragraph instanceof WithDeviceParagraphInterface) {
            /** @var ShortDeviceDTO $shortDeviceDTO */
            $shortDeviceDTO = ShortDeviceAdapter::adapt($paragraph->getDevice());
            $shortParagraphDTO->setDevice($shortDeviceDTO);
            /** @var FullParagraphFilterDTO $filter */
            $fullFilterDTO = FullParagraphFilterAdapter::adapt($paragraph->getFilter());
            $shortParagraphDTO->setFilter($fullFilterDTO);

            /** @var CollectionInterface $children */
            $children = $paragraph->getChildren();

            if ($children) {
                /** @var array $adaptChildren */
                $adaptChildren = self::adaptCollection($children);
                $shortParagraphDTO->setChildren($adaptChildren);
            }
        }

        return $shortParagraphDTO;
    }

    public static function adaptCollection(CollectionInterface $paragraphsCollection): array
    {
        /** @var FullParagraphDTO[] $paragraphs */
        $paragraphs = [];

        /** @var BaseParagraphInterface $paragraph */
        foreach ($paragraphsCollection as $paragraph) {
            $paragraphs[] = self::adapt($paragraph);
        }

        return $paragraphs;
    }
}
