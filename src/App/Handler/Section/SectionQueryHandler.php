<?php

namespace App\App\Handler\Section;

use App\Core\Model\Exception\InvalidSectionIdException;
use App\App\Query\Section\SectionQuery;
use App\Core\Model\Section\SectionId;
use App\Core\Model\Section\SectionInterface;
use App\Core\Repository\Section\SectionQueryRepositoryInterface;

class SectionQueryHandler
{
    /** @var SectionQueryRepositoryInterface  */
    protected $repository;

    /**
     * SectionQueryHandler constructor.
     * @param SectionQueryRepositoryInterface $repository
     */
    public function __construct(SectionQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param SectionQuery $query
     * @return SectionInterface|null
     * @throws InvalidSectionIdException
     */
    public function __invoke(SectionQuery $query): ?SectionInterface
    {
        return $this->repository->find(new SectionId($query->getId()));
    }
}
