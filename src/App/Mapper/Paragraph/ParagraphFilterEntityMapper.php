<?php

namespace App\App\Mapper\Paragraph;

use App\App\Doctrine\Entity\ParagraphFilter as ParagraphFilterEntity;
use App\App\Factory\Paragraph\ParagraphFilterFactoryInterface;
use App\Core\Model\Paragraph\ParagraphFilterInterface;

class ParagraphFilterEntityMapper implements ParagraphFilterEntityMapperInterface
{
    /** @var ParagraphFilterFactoryInterface */
    private $paragraphFilterFactory;

    /**
     * ParagraphFilterEntityMapper constructor.
     * @param ParagraphFilterFactoryInterface $paragraphFilterFactory
     */
    public function __construct(ParagraphFilterFactoryInterface $paragraphFilterFactory)
    {
        $this->paragraphFilterFactory = $paragraphFilterFactory;
    }

    /**
     * @param ParagraphFilterEntity $paragraphFilterEntity
     * @return ParagraphFilterInterface
     */
    public function map(ParagraphFilterEntity $paragraphFilterEntity): ParagraphFilterInterface
    {
        /** @var ParagraphFilterInterface $paragraphFilter */
        $paragraphFilter = $this->paragraphFilterFactory->make(
            $paragraphFilterEntity->getId(),
            $paragraphFilterEntity->getName()
        );
        $paragraphFilter->setDescription($paragraphFilterEntity->getDescription());

        return $paragraphFilter;
    }
}
