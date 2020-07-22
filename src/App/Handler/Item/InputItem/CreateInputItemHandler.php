<?php

namespace App\App\Handler\Item\InputItem;

use App\App\Command\Item\InputItem\CreateInputItemCommandInterface;
use App\App\Command\Item\InputItem\Validator\CreateInputItemValidatorInterface;
use App\App\UseCase\Item\InputItem\EditInputItemUseCaseInterface;
use App\Core\Repository\Item\ItemCommandRepositoryInterface;
use App\Infrastructure\Exception\Item\FailCreateInputItem;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateInputItemHandler implements MessageHandlerInterface
{
    /** @var ItemCommandRepositoryInterface */
    private $repository;
    /** @var CreateInputItemValidatorInterface */
    private $validator;
    /** @var EditInputItemUseCaseInterface */
    private $useCase;

    /**
     * CreateInputItemHandler constructor.
     * @param EditInputItemUseCaseInterface $useCase
     * @param CreateInputItemValidatorInterface $validator
     * @param ItemCommandRepositoryInterface $repository
     */
    public function __construct(
        EditInputItemUseCaseInterface $useCase,
        CreateInputItemValidatorInterface $validator,
        ItemCommandRepositoryInterface $repository
    ) {
        $this->useCase = $useCase;
        $this->validator = $validator;
        $this->repository = $repository;
    }

    /**
     * @param CreateInputItemCommandInterface $command
     * @throws FailCreateInputItem
     */
    public function __invoke(CreateInputItemCommandInterface $command)
    {
        try {
            $this->validator->validate($command);

            $item = $this->useCase->edit($command);

            $this->repository->create($item);
        } catch (\Exception $exception) {
            throw new FailCreateInputItem($exception->getMessage());
        }
    }
}
