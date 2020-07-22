<?php

namespace App\App\Handler\Item\ListItem;

use App\App\Command\Item\ListItem\CreateListItemCommandInterface;
use App\App\Command\Item\ListItem\Validator\CreateListItemValidatorInterface;
use App\App\UseCase\Item\ListItem\EditListItemUseCaseInterface;
use App\Core\Repository\Item\ItemCommandRepositoryInterface;
use App\Infrastructure\Exception\Item\FailCreateListItem;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateListItemHandler implements MessageHandlerInterface
{
    /** @var ItemCommandRepositoryInterface */
    private $repository;
    /** @var CreateListItemValidatorInterface */
    private $validator;
    /** @var EditListItemUseCaseInterface */
    private $useCase;

    /**
     * CreateInputItemHandler constructor.
     * @param EditListItemUseCaseInterface $useCase
     * @param CreateListItemValidatorInterface $validator
     * @param ItemCommandRepositoryInterface $repository
     */
    public function __construct(
        EditListItemUseCaseInterface $useCase,
        CreateListItemValidatorInterface $validator,
        ItemCommandRepositoryInterface $repository
    ) {
        $this->useCase = $useCase;
        $this->validator = $validator;
        $this->repository = $repository;
    }

    /**
     * @param CreateListItemCommandInterface $command
     * @throws FailCreateListItem
     */
    public function __invoke(CreateListItemCommandInterface $command)
    {
        try {
            $this->validator->validate($command);

            $item = $this->useCase->edit($command);

            $this->repository->create($item);
        } catch (\Exception $exception) {
            throw new FailCreateListItem($exception->getMessage());
        }
    }
}
