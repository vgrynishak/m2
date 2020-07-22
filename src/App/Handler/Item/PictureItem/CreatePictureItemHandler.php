<?php


namespace App\App\Handler\Item\PictureItem;

use App\App\Command\Item\PictureItem\CreatePictureItemCommandInterface;
use App\App\Command\Item\PictureItem\Validator\CreatePictureItemValidatorInterface;
use App\App\UseCase\Item\PictureItem\EditPictureItemUseCaseInterface;
use App\Core\Repository\Item\ItemCommandRepositoryInterface;
use App\Infrastructure\Exception\Item\FailCreatePictureItem;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreatePictureItemHandler implements MessageHandlerInterface
{
    /** @var ItemCommandRepositoryInterface */
    private $repository;
    /** @var CreatePictureItemValidatorInterface */
    private $validator;
    /** @var EditPictureItemUseCaseInterface */
    private $useCase;

    /**
     * CreatePictureItemHandler constructor.
     * @param EditPictureItemUseCaseInterface $useCase
     * @param CreatePictureItemValidatorInterface $validator
     * @param ItemCommandRepositoryInterface $repository
     */
    public function __construct(
        EditPictureItemUseCaseInterface $useCase,
        CreatePictureItemValidatorInterface $validator,
        ItemCommandRepositoryInterface $repository
    ) {
        $this->useCase = $useCase;
        $this->validator = $validator;
        $this->repository = $repository;
    }

    /**
     * @param CreatePictureItemCommandInterface $command
     * @throws FailCreatePictureItem
     */
    public function __invoke(CreatePictureItemCommandInterface $command)
    {
        try {
            $this->validator->validate($command);

            $item = $this->useCase->edit($command);

            $this->repository->create($item);
        }  catch (\Exception $exception) {
            throw new FailCreatePictureItem($exception->getMessage());
        }
    }
}