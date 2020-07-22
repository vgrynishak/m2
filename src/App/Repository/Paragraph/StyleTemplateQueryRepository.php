<?php

namespace App\App\Repository\Paragraph;

use App\App\Doctrine\Entity\StyleTemplate;
use App\App\Doctrine\Repository\StyleTemplateRepository;
use App\App\Mapper\Paragraph\StyleTemplateEntityMapperInterface;
use App\Core\Model\Paragraph\StyleTemplateId;
use App\Core\Model\Paragraph\StyleTemplateInterface;
use App\Core\Repository\Paragraph\StyleTemplateQueryRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class StyleTemplateQueryRepository implements StyleTemplateQueryRepositoryInterface
{
    public const DEFAULT_TEMPLATE = 'c11bbcc0-7862-4ffa-8669-586bca31e4c6';

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var StyleTemplateEntityMapperInterface */
    private $styleTemplateEntityMapper;

    /**
     * StyleTemplateQueryRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        StyleTemplateEntityMapperInterface $styleTemplateEntityMapper
    ) {
        $this->entityManager = $entityManager;
        $this->styleTemplateEntityMapper = $styleTemplateEntityMapper;
    }

    /**
     * @param StyleTemplateId $id
     * @return StyleTemplateInterface
     */
    public function find(StyleTemplateId $id): ?StyleTemplateInterface
    {
        /** @var StyleTemplateRepository $styleTemplateRepository */
        $styleTemplateRepository = $this->entityManager->getRepository('App:StyleTemplate');
        /** @var StyleTemplate $styleTemplateEntity */
        $styleTemplateEntity = $styleTemplateRepository->find($id->getValue());

        if (!$styleTemplateEntity instanceof StyleTemplate) {
            return null;
        }

        return $this->styleTemplateEntityMapper->map($styleTemplateEntity);
    }
}
