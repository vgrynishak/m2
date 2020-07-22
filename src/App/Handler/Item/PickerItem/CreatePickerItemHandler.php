<?php

namespace App\App\Handler\Item\PickerItem;

use App\App\Command\Item\PickerItem\CreatePickerItemCommandInterface;
use App\App\Command\Item\PickerItem\Validator\CreatePickerItemValidatorInterface;
use App\App\UseCase\Item\PickerItem\EditPickerItemUseCaseInterface;
use App\Core\Repository\Item\ItemCommandRepositoryInterface;
use App\Infrastructure\Exception\Item\FailCreatePickerItem;

class CreatePickerItemHandler
{
    /** @var ItemCommandRepositoryInterface */
    private $repository;
    /** @var CreatePickerItemValidatorInterface */
    private $validator;
    /** @var EditPickerItemUseCaseInterface */
    private $useCase;

    /**
     * CreateInputItemHandler constructor.
     * @param EditPickerItemUseCaseInterface $useCase
     * @param CreatePickerItemValidatorInterface $validator
     * @param ItemCommandRepositoryInterface $repository
     */
    public function __construct(
        EditPickerItemUseCaseInterface $useCase,
        CreatePickerItemValidatorInterface $validator,
        ItemCommandRepositoryInterface $repository
    ) {
        $this->useCase = $useCase;
        $this->validator = $validator;
        $this->repository = $repository;
    }

    /**
     * @param CreatePickerItemCommandInterface $command
     * @throws FailCreatePickerItem(
     */
    public function __invoke(CreatePickerItemCommandInterface $command)
    {
        try {
            $this->validator->validate($command);

            $item = $this->useCase->edit($command);

            $this->repository->create($item);
        } catch (\Exception $exception) {
            throw new FailCreatePickerItem($exception->getMessage());
        }
    }
}
