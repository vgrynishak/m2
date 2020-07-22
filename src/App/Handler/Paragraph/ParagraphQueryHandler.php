<?php

namespace App\App\Handler\Paragraph;

use App\App\Query\Paragraph\ParagraphQuery;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;

class ParagraphQueryHandler
{
    /** @var ParagraphQueryRepositoryInterface  */
    protected $repository;

    /**
     * ParagraphQueryHandler constructor.
     * @param ParagraphQueryRepositoryInterface $repository
     */
    public function __construct(ParagraphQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ParagraphQuery $query)
    {
        return $this->repository->find($query->getId());
    }
}
