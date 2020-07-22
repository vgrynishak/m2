<?php

namespace App\App\Handler\Item\ChangeItemPosition;

use App\App\Command\Item\ChangeItemPosition\ChangeItemPositionCommandInterface;
use App\App\Command\Item\ChangeItemPosition\Validator\ChangeItemPositionValidatorInterface;
use App\Core\Model\Item\ItemInterface;
use App\Core\Repository\Item\ItemCommandRepositoryInterface;
use App\Core\Repository\Item\ItemQueryRepositoryInterface;
use App\Infrastructure\Exception\Item\FailChangeItemPosition;

class ChangeItemPositionHandler
{
    /** @var ChangeItemPositionValidatorInterface */
    private $changeItemPositionValidator;
    /** @var ItemQueryRepositoryInterface */
    private $itemQueryRepository;
    /** @var ItemCommandRepositoryInterface */
    private $itemCommandRepository;

    /**
     * @param ChangeItemPositionCommandInterface $command
     * @throws FailChangeItemPosition
     */
    public function __invoke(ChangeItemPositionCommandInterface $command)
    {
        try {
            $this->changeItemPositionValidator->validate($command);
            /** @var ItemInterface $item */
            $item = $this->itemQueryRepository->find($command->getId());

            $this->itemCommandRepository->changePosition($item, $command->getNewPosition());
        } catch (\Exception $exception) {
            throw new FailChangeItemPosition($exception->getMessage());
        }
    }

    /**
     * ChangeItemPositionHandler constructor.
     * @param ChangeItemPositionValidatorInterface $changeItemPositionValidator
     * @param ItemQueryRepositoryInterface $itemQueryRepository
     * @param ItemCommandRepositoryInterface $itemCommandRepository
     */
    public function __construct(
        ChangeItemPositionValidatorInterface $changeItemPositionValidator,
        ItemQueryRepositoryInterface $itemQueryRepository,
        ItemCommandRepositoryInterface $itemCommandRepository
    ) {
        $this->changeItemPositionValidator = $changeItemPositionValidator;
        $this->itemQueryRepository = $itemQueryRepository;
        $this->itemCommandRepository = $itemCommandRepository;
    }
}
