<?php

namespace App\App\Command\Item\ChangeItemPosition\Validator;

use App\App\Command\Item\ChangeItemPosition\ChangeItemPositionCommandInterface;
use App\Core\Model\Item\ItemInterface;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Repository\Item\ItemQueryRepositoryInterface;

class ChangeItemPositionValidator implements ChangeItemPositionValidatorInterface
{
    /** @var ItemQueryRepositoryInterface  */
    private $itemQueryRepository;

    /**
     * ChangeItemPositionValidator constructor.
     * @param ItemQueryRepositoryInterface $itemQueryRepository
     */
    public function __construct(ItemQueryRepositoryInterface $itemQueryRepository)
    {
        $this->itemQueryRepository = $itemQueryRepository;
    }

    /**
     * @param ChangeItemPositionCommandInterface $command
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function validate(ChangeItemPositionCommandInterface $command): bool
    {
        try {
            /** @var BaseParagraphInterface|null $item */
            $item = $this->itemQueryRepository->find($command->getId());

            if (!$item instanceof ItemInterface) {
                throw new \InvalidArgumentException('Item is not exist');
            }

            if ($command->getNewPosition() < 1) {
                throw new \InvalidArgumentException('New position can not be lass than 1');
            }

            if ($command->getNewPosition() > $this->itemQueryRepository->getMaxPosition($item->getParagraphId())) {
                throw new \InvalidArgumentException(
                    'New position can not be more than max position in paragraph'
                );
            }

            return true;
        } catch (\Exception $exception) {
            throw new \InvalidArgumentException($exception->getMessage());
        }
    }
}
