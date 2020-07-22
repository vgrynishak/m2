<?php

namespace App\App\Repository\Dictionary;

use App\App\Doctrine\Repository\Item\DictionaryRepository;
use App\App\Doctrine\Mapper\Dictionary\DictionaryEntityToModelMapperInterface;
use App\Core\Model\Item\InformationItem\Dictionary\DictionaryId;
use App\Core\Model\Item\InformationItem\Dictionary\DictionaryInterface;
use App\Core\Repository\Dictionary\DictionaryQueryRepositoryInterface;

class DictionaryQueryRepository implements DictionaryQueryRepositoryInterface
{
    /** @var DictionaryRepository */
    private $dictionaryRepository;
    /** @var DictionaryEntityToModelMapperInterface */
    private $mapper;

    /**
     * DictionaryQueryRepository constructor.
     * @param DictionaryRepository $dictionaryRepository
     * @param DictionaryEntityToModelMapperInterface $mapper
     */
    public function __construct(
        DictionaryRepository $dictionaryRepository,
        DictionaryEntityToModelMapperInterface $mapper
    ) {
        $this->dictionaryRepository = $dictionaryRepository;
        $this->mapper = $mapper;
    }

    /**
     * @inheritDoc
     */
    public function find(DictionaryId $dictionaryId): ?DictionaryInterface
    {
        $dictionaryEntity = $this->dictionaryRepository->find($dictionaryId->getValue());

        if (!$dictionaryEntity) {
            return null;
        }

        return $this->mapper->map($dictionaryEntity);
    }
}
