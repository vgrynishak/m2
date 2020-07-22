<?php

namespace App\App\Handler\Item\PickerItem;

use App\App\Command\Item\PickerItem\UpdatePickerItemCommandInterface;
use App\App\Command\Item\PickerItem\Validator\UpdatePickerItemValidatorInterface;
use App\App\UseCase\Item\PickerItem\EditPickerItemUseCaseInterface;
use App\Core\Repository\Item\ItemCommandRepositoryInterface;
use App\Infrastructure\Exception\Item\FailUpdatePickerItem;

class UpdatePickerItemHandler
{
    /** @var ItemCommandRepositoryInterface */
    private $repository;
    /** @var UpdatePickerItemValidatorInterface */
    private $validator;
    /** @var EditPickerItemUseCaseInterface */
    private $useCase;

    /**
     * CreateInputItemHandler constructor.
     * @param EditPickerItemUseCaseInterface $useCase
     * @param UpdatePickerItemValidatorInterface $validator
     * @param ItemCommandRepositoryInterface $repository
     */
    public function __construct(
        EditPickerItemUseCaseInterface $useCase,
        UpdatePickerItemValidatorInterface $validator,
        ItemCommandRepositoryInterface $repository
    ) {
        $this->useCase = $useCase;
        $this->validator = $validator;
        $this->repository = $repository;
    }

    /**
     * @param UpdatePickerItemCommandInterface $command
     * @throws FailUpdatePickerItem
     */
    public function __invoke(UpdatePickerItemCommandInterface $command)
    {
        try {
            $this->validator->validate($command);

            $item = $this->useCase->edit($command);

            $this->repository->update($item);
        } catch (\Exception $exception) {
            throw new FailUpdatePickerItem($exception->getMessage());
        }
    }
}
