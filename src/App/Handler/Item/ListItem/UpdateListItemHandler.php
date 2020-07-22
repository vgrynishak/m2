<?php

namespace App\App\Handler\Item\ListItem;

use App\App\Command\Item\ListItem\UpdateListItemCommandInterface;
use App\App\Command\Item\ListItem\Validator\UpdateListItemValidatorInterface;
use App\App\UseCase\Item\ListItem\EditListItemUseCaseInterface;
use App\Core\Repository\Item\ItemCommandRepositoryInterface;
use App\Infrastructure\Exception\Item\FailUpdateListItem;

class UpdateListItemHandler
{
    /** @var ItemCommandRepositoryInterface */
    private $repository;
    /** @var UpdateListItemValidatorInterface */
    private $validator;
    /** @var EditListItemUseCaseInterface */
    private $useCase;

    /**
     * CreateInputItemHandler constructor.
     * @param EditListItemUseCaseInterface $useCase
     * @param UpdateListItemValidatorInterface $validator
     * @param ItemCommandRepositoryInterface $repository
     */
    public function __construct(
        EditListItemUseCaseInterface $useCase,
        UpdateListItemValidatorInterface $validator,
        ItemCommandRepositoryInterface $repository
    ) {
        $this->useCase = $useCase;
        $this->validator = $validator;
        $this->repository = $repository;
    }

    /**
     * @param UpdateListItemCommandInterface $command
     * @throws FailUpdateListItem
     */
    public function __invoke(UpdateListItemCommandInterface $command)
    {
        try {
            $this->validator->validate($command);

            $item = $this->useCase->edit($command);

            $this->repository->update($item);
        } catch (\Exception $exception) {
            throw new FailUpdateListItem($exception->getMessage());
        }
    }
}
