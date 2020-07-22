<?php

namespace App\App\Repository\InfoSource;

use App\App\Doctrine\Entity\Item\InfoSource as InfoSourceEntity;
use App\App\Doctrine\Repository\Item\InfoSourceRepository;
use App\App\Doctrine\Mapper\InfoSource\InfoSourceEntityToModelMapperInterface;
use App\Core\Model\Exception\InvalidDictionaryIdException;
use App\Core\Model\Exception\InvalidInfoSourceIdException;
use App\Core\Model\Item\InformationItem\Dictionary\DictionaryId;
use App\Core\Model\Item\InformationItem\InfoSource\InfoSourceId;
use App\Core\Model\Item\InformationItem\InfoSource\InfoSourceInterface;
use App\Core\Repository\InfoSource\InfoSourceQueryRepositoryInterface;
use PhpCollection\CollectionInterface;
use PhpCollection\Set;

class InfoSourceQueryRepository implements InfoSourceQueryRepositoryInterface
{
    /** @var InfoSourceRepository */
    private $infoSourceRepository;

    /** @var InfoSourceEntityToModelMapperInterface */
    private $mapper;

    /**
     * InfoSourceQueryRepository constructor.
     * @param InfoSourceRepository $infoSourceRepository
     * @param InfoSourceEntityToModelMapperInterface $mapper
     */
    public function __construct(
        InfoSourceRepository $infoSourceRepository,
        InfoSourceEntityToModelMapperInterface $mapper
    ) {
        $this->infoSourceRepository = $infoSourceRepository;
        $this->mapper = $mapper;
    }

    /**
     * @param InfoSourceId $id
     * @return InfoSourceInterface|null
     * @throws InvalidDictionaryIdException
     * @throws InvalidInfoSourceIdException
     */
    public function find(InfoSourceId $id): ?InfoSourceInterface
    {
        $infoSourceEntity = $this->infoSourceRepository->find($id->getValue());

        if (!$infoSourceEntity instanceof InfoSourceEntity) {
            return null;
        }

        return $this->mapper->map($infoSourceEntity);
    }


    /**
     * @param DictionaryId $dictionaryId
     * @return CollectionInterface|null
     * @throws InvalidDictionaryIdException
     * @throws InvalidInfoSourceIdException
     */
    public function findAllByDictionaryId(DictionaryId $dictionaryId): ?CollectionInterface
    {
        $infoSourceEntities = $this->infoSourceRepository->findBy([
            'dictionary' => $dictionaryId->getValue()
        ]);

        if (!$infoSourceEntities) {
            return null;
        }
        $infoSources = [];
        /** @var InfoSourceEntity $infoSource */
        foreach ($infoSourceEntities as $infoSource) {
            $infoSources[] = $this->mapper->map($infoSource);
        }

        return new Set($infoSources);
    }
}
