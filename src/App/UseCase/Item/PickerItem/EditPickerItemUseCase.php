<?php

namespace App\App\UseCase\Item\PickerItem;

use App\App\Command\Item\BaseItemCommandInterface;
use App\App\Command\Item\Mapper\ItemMapperByCommandInterface;
use App\App\Command\Item\PickerItem\CreatePickerItemCommandInterface;
use App\App\Factory\Exception\FailMakeItemModel;
use App\Core\Model\Item\ItemInterface;
use App\Core\Service\Item\PositionIteratorInterface;

class EditPickerItemUseCase implements EditPickerItemUseCaseInterface
{
    /** @var ItemMapperByCommandInterface */
    private $mapper;
    /** @var PositionIteratorInterface */
    private $iterator;

    /**
     * EditInputItemUseCase constructor.
     * @param PositionIteratorInterface $iterator
     * @param ItemMapperByCommandInterface $mapper
     */
    public function __construct(
        PositionIteratorInterface $iterator,
        ItemMapperByCommandInterface $mapper
    ) {
        $this->mapper = $mapper;
        $this->iterator = $iterator;
    }

    /**
     * @param BaseItemCommandInterface $command
     * @return ItemInterface
     * @throws FailMakeItemModel
     */
    public function edit(BaseItemCommandInterface $command): ItemInterface
    {
        $item = $this->mapper->map($command);

        if ($command instanceof CreatePickerItemCommandInterface) {
            $item->setPosition($this->iterator->next($command->getParagraphId()));
        }

        return $item;
    }
}
