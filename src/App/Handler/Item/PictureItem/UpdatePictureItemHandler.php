<?php


namespace App\App\Handler\Item\PictureItem;

use App\App\Command\Item\PictureItem\UpdatePictureItemCommandInterface;
use App\App\Command\Item\PictureItem\Validator\UpdatePictureItemValidatorInterface;
use App\App\UseCase\Item\PictureItem\EditPictureItemUseCaseInterface;
use App\Core\Repository\Item\ItemCommandRepositoryInterface;
use App\Infrastructure\Exception\Item\FailUpdatePictureItem;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UpdatePictureItemHandler implements MessageHandlerInterface
{
    /** @var ItemCommandRepositoryInterface */
    private $repository;
    /** @var UpdatePictureItemValidatorInterface */
    private $validator;
    /** @var EditPictureItemUseCaseInterface */
    private $useCase;

    /**
     * CreatePictureItemHandler constructor.
     * @param EditPictureItemUseCaseInterface $useCase
     * @param UpdatePictureItemValidatorInterface $validator
     * @param ItemCommandRepositoryInterface $repository
     */
    public function __construct(
        EditPictureItemUseCaseInterface $useCase,
        UpdatePictureItemValidatorInterface $validator,
        ItemCommandRepositoryInterface $repository
    ) {
        $this->useCase = $useCase;
        $this->validator = $validator;
        $this->repository = $repository;
    }

    /**
     * @param UpdatePictureItemCommandInterface $command
     * @throws FailUpdatePictureItem
     */
    public function __invoke(UpdatePictureItemCommandInterface $command)
    {
        try {
            $this->validator->validate($command);

            $item = $this->useCase->edit($command);

            $this->repository->update($item);
        }  catch (\Exception $exception) {
            throw new FailUpdatePictureItem($exception->getMessage());
        }
    }
}