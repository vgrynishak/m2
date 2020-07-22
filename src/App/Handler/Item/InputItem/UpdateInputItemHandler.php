<?php

namespace App\App\Handler\Item\InputItem;

use App\App\Command\Item\InputItem\UpdateInputItemCommandInterface;
use App\App\Command\Item\InputItem\Validator\UpdateInputItemValidatorInterface;
use App\App\UseCase\Item\InputItem\EditInputItemUseCaseInterface;
use App\Core\Repository\Item\ItemCommandRepositoryInterface;
use App\Infrastructure\Exception\Item\FailUpdateInputItem;

class UpdateInputItemHandler
{
    /** @var ItemCommandRepositoryInterface */
    private $repository;
    /** @var UpdateInputItemValidatorInterface */
    private $validator;
    /** @var EditInputItemUseCaseInterface */
    private $useCase;

    /**
     * CreateInputItemHandler constructor.
     * @param EditInputItemUseCaseInterface $useCase
     * @param UpdateInputItemValidatorInterface $validator
     * @param ItemCommandRepositoryInterface $repository
     */
    public function __construct(
        EditInputItemUseCaseInterface $useCase,
        UpdateInputItemValidatorInterface $validator,
        ItemCommandRepositoryInterface $repository
    ) {
        $this->useCase = $useCase;
        $this->validator = $validator;
        $this->repository = $repository;
    }

    /**
     * @param UpdateInputItemCommandInterface $command
     * @throws FailUpdateInputItem
     */
    public function __invoke(UpdateInputItemCommandInterface $command)
    {
        try {
            $this->validator->validate($command);

            $item = $this->useCase->edit($command);

            $this->repository->update($item);
        } catch (\Exception $exception) {
            throw new FailUpdateInputItem($exception->getMessage());
        }
    }
}
