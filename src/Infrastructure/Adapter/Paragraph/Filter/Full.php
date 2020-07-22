<?php

namespace App\Infrastructure\Adapter\Paragraph\Filter;

use App\Core\Model\Paragraph\ParagraphFilterInterface;
use App\Infrastructure\Adapter\DTO\Paragraph\Filter\Full as FullParagraphFilterDTO;

class Full
{
    /**
     * @param ParagraphFilterInterface $paragraphFilter
     * @return FullParagraphFilterDTO
     */
    public static function adapt(ParagraphFilterInterface $paragraphFilter): FullParagraphFilterDTO
    {
        /** @var FullParagraphFilterDTO $fullParagraphFilter */
        $fullParagraphFilter = new FullParagraphFilterDTO(
            $paragraphFilter->getId()->getValue(),
            $paragraphFilter->getName()
        );
        //$fullParagraphFilter->setDescription($paragraphFilter->getDescription());

        return $fullParagraphFilter;
    }
}
