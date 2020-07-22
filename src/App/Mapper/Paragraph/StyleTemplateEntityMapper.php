<?php

namespace App\App\Mapper\Paragraph;

use App\App\Doctrine\Entity\StyleTemplate as StyleTemplateEntity;
use App\App\Factory\Paragraph\StyleTemplateFactoryInterface;
use App\Core\Model\Paragraph\StyleTemplateInterface;

class StyleTemplateEntityMapper implements StyleTemplateEntityMapperInterface
{
    /** @var StyleTemplateFactoryInterface */
    private $styleTemplateFactory;

    /**
     * DoctrineEntityStyleTemplateMapper constructor.
     * @param StyleTemplateFactoryInterface $styleTemplateFactory
     */
    public function __construct(StyleTemplateFactoryInterface $styleTemplateFactory)
    {
        $this->styleTemplateFactory = $styleTemplateFactory;
    }

    /**
     * @param StyleTemplateEntity $styleTemplateEntity
     * @return StyleTemplateInterface
     */
    public function map(StyleTemplateEntity $styleTemplateEntity): StyleTemplateInterface
    {
        /** @var StyleTemplateInterface $styleTemplate */
        $styleTemplate = $this->styleTemplateFactory->make(
            $styleTemplateEntity->getId(),
            $styleTemplateEntity->getName()
        );

        return $styleTemplate;
    }
}
