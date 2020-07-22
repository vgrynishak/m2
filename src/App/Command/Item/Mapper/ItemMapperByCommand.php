<?php

namespace App\App\Command\Item\Mapper;

use App\App\Command\Item\Base\AnswersInterface;
use App\App\Command\Item\Base\DefaultAnswerInterface;
use App\App\Command\Item\Base\InfoSourceInterface;
use App\App\Command\Item\Base\NFPArefInterface;
use App\App\Command\Item\Base\PlaceholderInterface;
use App\App\Command\Item\Base\RememberedInterface;
use App\App\Command\Item\Base\RequiredInterface;
use App\App\Command\Item\BaseItemCommandInterface;
use App\App\Command\Item\Base\LabelInterface;
use App\App\Factory\Item\ItemFactoryInterface;
use App\App\Factory\Exception\FailMakeItemModel;
use App\Core\Model\Item\Base\NFPAInterface as ItemNFPAInterface;
use App\Core\Model\Item\Base\OptionInterface as ItemOptionInterface;
use App\Core\Model\Item\Base\RememberInterface as ItemRememberInterface;
use App\Core\Model\Item\Base\RequireInterface as ItemRequireInterface;
use App\Core\Model\Item\ItemInterface;
use App\Core\Model\Item\Base\PlaceholderInterface as ItemPlaceholderInterface;
use App\Core\Model\Item\Base\LabelInterface as ItemLabelInterface;
use App\Core\Model\Item\Base\DefaultAnswerInterface as ItemDefaultAnswerInterface;
use App\Core\Model\Item\Base\InfoSourceInterface as ItemInfoSourceInterface;
use App\Core\Repository\InfoSource\InfoSourceQueryRepositoryInterface;

class ItemMapperByCommand implements ItemMapperByCommandInterface
{
    /** @var ItemFactoryInterface */
    private $itemFactory;
    /** @var InfoSourceQueryRepositoryInterface */
    private $infoSourceQueryRepository;

    /**
     * ItemMapperByCommand constructor.
     * @param ItemFactoryInterface $itemFactory
     * @param InfoSourceQueryRepositoryInterface $infoSourceQueryRepository
     */
    public function __construct(
        ItemFactoryInterface $itemFactory,
        InfoSourceQueryRepositoryInterface $infoSourceQueryRepository
    ) {
        $this->itemFactory = $itemFactory;
        $this->infoSourceQueryRepository = $infoSourceQueryRepository;
    }

    /**
     * @param BaseItemCommandInterface $command
     * @return ItemInterface
     * @throws FailMakeItemModel
     */
    public function map(BaseItemCommandInterface $command): ItemInterface
    {
        try {
            $item = $this->itemFactory->make($command->getId(), $command->getParagraphId(), $command->getItemTypeId());

            $item->setPrintable($command->getPrintable());
            $item->setUpdatedAt(new \DateTime());
            $item->setCreatedAt(new \DateTime());

            if ($command instanceof NFPArefInterface && $item instanceof ItemNFPAInterface) {
                $item->setNFPA($command->getNFPAref());
            }
            if ($command instanceof PlaceholderInterface && $item instanceof ItemPlaceholderInterface) {
                $item->setPlaceholder($command->getPlaceholder());
            }
            if ($command instanceof LabelInterface && $item instanceof ItemLabelInterface) {
                $item->setLabel($command->getLabel());
            }
            if ($command instanceof RememberedInterface && $item instanceof ItemRememberInterface) {
                $item->setRemember($command->getRemembered());
            }
            if ($command instanceof RequiredInterface && $item instanceof ItemRequireInterface) {
                $item->setRequire($command->getRequired());
            }
            if ($command instanceof DefaultAnswerInterface && $item instanceof ItemDefaultAnswerInterface) {
                $item->setDefaultAnswer($command->getDefaultAnswer());
            }
            if ($command instanceof AnswersInterface && $item instanceof ItemOptionInterface) {
                $item->setOptions($command->getAnswers());
            }
            if ($command instanceof InfoSourceInterface && $item instanceof ItemInfoSourceInterface) {
                $item->setInfoSource($this->infoSourceQueryRepository->find($command->getInfoSourceId()));
            }
            return $item;
        } catch (\Exception $exception) {
            throw new FailMakeItemModel($exception->getMessage());
        }
    }
}
