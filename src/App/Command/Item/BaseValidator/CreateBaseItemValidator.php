<?php

namespace App\App\Command\Item\BaseValidator;

use App\App\Command\Item\BaseItemCommandInterface;
use App\Core\Model\Item\ItemInterface;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Repository\Item\ItemQueryRepositoryInterface;
use App\Core\Repository\Item\ItemType\ItemTypeQueryRepositoryInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;
use InvalidArgumentException;

class CreateBaseItemValidator
{
    /** @var ParagraphQueryRepositoryInterface */
    protected $paragraphQueryRepository;
    /** @var ItemQueryRepositoryInterface */
    protected $itemQueryRepository;
    /** @var ItemTypeQueryRepositoryInterface */
    protected $itemTypeQueryRepository;

    /**
     * CreateBaseItemValidator constructor.
     * @param ParagraphQueryRepositoryInterface $paragraphQueryRepository
     * @param ItemQueryRepositoryInterface $itemQueryRepository
     * @param ItemTypeQueryRepositoryInterface $itemTypeQueryRepository
     */
    public function __construct(
        ParagraphQueryRepositoryInterface $paragraphQueryRepository,
        ItemQueryRepositoryInterface $itemQueryRepository,
        ItemTypeQueryRepositoryInterface $itemTypeQueryRepository
    ) {
        $this->paragraphQueryRepository = $paragraphQueryRepository;
        $this->itemQueryRepository = $itemQueryRepository;
        $this->itemTypeQueryRepository = $itemTypeQueryRepository;
    }

    /**
     * @param BaseItemCommandInterface $command
     * @throws InvalidArgumentException
     */
    public function validate(BaseItemCommandInterface $command): void
    {
        try {
            $itemType = $this->itemTypeQueryRepository->find($command->getItemTypeId());

            if (!$itemType) {
                throw new InvalidArgumentException('itemTypeId not exists');
            }

            $item = $this->itemQueryRepository->find($command->getId());

            if ($item instanceof ItemInterface) {
                throw new InvalidArgumentException('Item Id already exists');
            }

            $paragraph = $this->paragraphQueryRepository->find($command->getParagraphId());
            if (!$paragraph instanceof BaseParagraphInterface) {
                throw new InvalidArgumentException('Not found paragraphId');
            }
        } catch (\Exception $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
}
