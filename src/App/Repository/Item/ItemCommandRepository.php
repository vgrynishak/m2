<?php

namespace App\App\Repository\Item;

use App\App\Doctrine\Entity\User as UserEntity;
use App\App\Doctrine\Exception\NonExistentEntity;
use App\App\Doctrine\Mapper\Answer\AnswerMapperInterface;
use App\App\Doctrine\Repository\Item\InfoSourceRepository;
use App\App\Repository\Exception\FailCreateItemException;
use App\App\Repository\Exception\FailUpdateItemException;
use App\App\Repository\Exception\FailUpdateListInputItemException;
use App\Core\Model\Answer\Answer;
use App\App\Doctrine\Entity\Item\Item as ItemEntity;
use App\App\Doctrine\Mapper\Item\ItemMapperInterface;
use App\App\Doctrine\Repository\AnswerRepository;
use App\Core\Model\Item\InputItem\InputItemInterface;
use App\Core\Model\Item\ItemInterface;
use App\Core\Model\Item\ListItem\ListItemInterface;
use App\Core\Repository\Item\ItemCommandRepositoryInterface;
use App\Core\Service\Item\ChangePositionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use PhpCollection\CollectionInterface;
use App\Core\Model\Item\Base\InfoSourceInterface as ItemInfoSourceInterface;

class ItemCommandRepository implements ItemCommandRepositoryInterface
{
    /** @var ItemMapperInterface */
    private $mapper;
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var AnswerRepository */
    private $answerRepository;
    /** @var AnswerMapperInterface */
    private $answerMapper;
    /** @var InfoSourceRepository */
    private $infoSourceRepository;
    /** @var ChangePositionInterface */
    private $changePosition;

    /**
     * ItemCommandRepository constructor.
     * @param ItemMapperInterface $mapper
     * @param EntityManagerInterface $entityManager
     * @param AnswerRepository $answerRepository
     * @param AnswerMapperInterface $answerMapper
     * @param InfoSourceRepository $infoSourceRepository
     * @param ChangePositionInterface $changePosition
     */
    public function __construct(
        ItemMapperInterface $mapper,
        EntityManagerInterface $entityManager,
        AnswerRepository $answerRepository,
        AnswerMapperInterface $answerMapper,
        InfoSourceRepository $infoSourceRepository,
        ChangePositionInterface $changePosition
    ) {
        $this->mapper = $mapper;
        $this->entityManager = $entityManager;
        $this->answerRepository = $answerRepository;
        $this->answerMapper = $answerMapper;
        $this->infoSourceRepository = $infoSourceRepository;
        $this->changePosition = $changePosition;
    }

    /**
     * @param ItemInterface $item
     * @throws FailCreateItemException
     */
    public function create(ItemInterface $item): void
    {
        /** @var ItemInterface | InputItemInterface $item */
        try {
            $itemEntity = $this->mapper->mapNew($item);

            if ($item instanceof InputItemInterface) {
                $this->createInputItem($item, $itemEntity);
            }
            if ($item instanceof ListItemInterface) {
                $this->createListItem($item, $itemEntity);
            }

            if ($item instanceof ItemInfoSourceInterface && $item->getInfoSource()) {
                $itemEntity->setInfoSource(
                    $this->infoSourceRepository->find(
                        $item->getInfoSource()->getId()->getValue()
                    )
                );
            }

            $this->entityManager->persist($itemEntity);
            $this->entityManager->flush();
        } catch (Exception $e) {
            throw new FailCreateItemException($e->getMessage());
        }
    }

    /**
     * @param ItemInterface $item
     * @throws FailUpdateItemException
     */
    public function update(ItemInterface $item): void
    {
        try {
            $itemEntity = $this->mapper->map($item);

            if ($item instanceof InputItemInterface) {
                $this->updateInputItem($item, $itemEntity);
            }
            if ($item instanceof ListItemInterface) {
                $this->updateListItem($item, $itemEntity);
            }

            if ($item instanceof ItemInfoSourceInterface && $item->getInfoSource()) {
                $itemEntity->setInfoSource(
                    $this->infoSourceRepository->find(
                        $item->getInfoSource()->getId()->getValue()
                    )
                );
            }

            $this->entityManager->persist($itemEntity);
            $this->entityManager->flush();
        } catch (Exception $e) {
            throw new FailUpdateItemException($e->getMessage());
        }
    }

    /**
     * @param CollectionInterface $items
     * @throws NonExistentEntity
     */
    public function deleteList(CollectionInterface $items): void
    {
        $this->entityManager->beginTransaction();

        /** @var ItemInterface $item */
        foreach ($items as $item) {
            /** @var ItemEntity $itemEntity */
            $itemEntity = $this->mapper->map($item);

            if ($itemEntity->getDefaultAnswer()) {
                $itemEntity->setDefaultAnswer(null);
                $this->entityManager->flush();
            }

            $this->entityManager->remove($itemEntity);
        }
        $this->entityManager->flush();

        $this->entityManager->commit();
    }

    /**
     * @param InputItemInterface $item
     * @param ItemEntity $itemEntity
     * @throws NonExistentEntity
     */
    private function createInputItem(InputItemInterface $item, ItemEntity $itemEntity): void
    {
        if (!$item->getDefaultAnswer()) {
            return ;
        }

        $answerEntity = $this->answerMapper->mapNew($item->getDefaultAnswer());

        $answerEntity->setItem($itemEntity);
        $itemEntity->setDefaultAnswer($answerEntity);

        $this->entityManager->persist($answerEntity);
    }

    /**
     * @param ListItemInterface $item
     * @param ItemEntity $itemEntity
     * @throws NonExistentEntity
     */
    private function createListItem(ListItemInterface $item, ItemEntity $itemEntity): void
    {
        if (!$item->getOptions() || !$item->getOptions()->count()) {
            return ;
        }

        foreach ($item->getOptions() as $answerModel) {
            $answerEntity = $this->answerMapper->mapNew($answerModel);
            $answerEntity->setItem($itemEntity);

            if (($defaultAnswer = $item->getDefaultAnswer()) && $defaultAnswer === $answerModel) {
                $itemEntity->setDefaultAnswer($answerEntity);
            }

            $this->entityManager->persist($answerEntity);
        }
    }

    /**
     * @param InputItemInterface $item
     * @param ItemEntity $itemEntity
     * @throws NonExistentEntity
     */
    private function updateInputItem(InputItemInterface $item, ItemEntity $itemEntity): void
    {
        if (!$itemEntity->getDefaultAnswer() && !$item->getDefaultAnswer()) {
            return ;
        }

        if ($itemEntity->getDefaultAnswer() && !$item->getDefaultAnswer()) {
            $this->entityManager->remove($itemEntity->getDefaultAnswer());
            $itemEntity->setDefaultAnswer(null);
        } elseif (!$itemEntity->getDefaultAnswer() && $item->getDefaultAnswer()) {
            $this->createInputItem($item, $itemEntity);
        } else {
            $answerEntity = $this->answerMapper->map($item->getDefaultAnswer());
            $answerEntity->setItem($itemEntity);
            $itemEntity->setDefaultAnswer($answerEntity);
            $this->entityManager->persist($answerEntity);
        }
    }

    /**
     * @param ListItemInterface $item
     * @param ItemEntity $itemEntity
     * @throws FailUpdateListInputItemException
     * @throws NonExistentEntity
     */
    private function updateListItem(ListItemInterface $item, ItemEntity $itemEntity): void
    {
        if (!$item->getOptions() || !$item->getOptions()->count()) {
            return ;
        }

        /** @var Answer $answer */
        foreach ($item->getOptions() as $answer) {
            $answerEntity = $this->answerRepository->find($answer->getId()->getValue());

            if ($answerEntity) {
                if ($answerEntity->getItem()->getId() !== $item->getId()->getValue()) {
                    throw new FailUpdateListInputItemException('invalid answer id');
                }
                $answerEntity = $this->answerMapper->map($answer);
            } else {
                $answerEntity = $this->answerMapper->mapNew($answer);
            }
            $answerEntity->setItem($itemEntity);

            $defaultAnswer = $item->getDefaultAnswer();

            if (!$defaultAnswer && $itemEntity->getDefaultAnswer()) {
                $this->entityManager->remove($itemEntity->getDefaultAnswer());
                $itemEntity->setDefaultAnswer(null);
            }
            if ($defaultAnswer && $defaultAnswer === $answer) {
                $itemEntity->setDefaultAnswer($answerEntity);
            }

            $this->entityManager->persist($answerEntity);
        }
        $this->deleteAnswers($item, $itemEntity);
    }

    /**
     * @param ListItemInterface $item
     * @param ItemEntity $itemEntity
     */
    private function deleteAnswers(ListItemInterface $item, ItemEntity $itemEntity): void
    {
        $allAnswersEntity = $this->answerRepository->findBy([
            'item' => $itemEntity
        ]);

        $answerIds = $this->prepareData($item->getOptions());

        foreach ($allAnswersEntity as $answerEntity) {
            if (!in_array($answerEntity->getId(), $answerIds, true)) {
                 $this->entityManager->remove($answerEntity);
            }
        }
    }

    /**
     * @param CollectionInterface $answers
     * @return array
     */
    private function prepareData(CollectionInterface $answers): array
    {
        $resultIds = [];

        /** @var Answer $answer */
        foreach ($answers as $answer) {
            $resultIds[] = $answer->getId()->getValue();
        }
        return $resultIds;
    }

    /**
     * @inheritDoc
     */
    public function changePosition(ItemInterface $item, int $newPosition)
    {
        /** @var int $currentItemPosition */
        $currentItemPosition = $item->getPosition();

        if ($currentItemPosition > $newPosition) {
            $this->changePosition->increaseItemListInPosition($item, $newPosition);
        } else {
            $this->changePosition->decreaseItemListInPosition($item, $newPosition);
        }

        $ItemEntity = $this->mapper->map($item);
        $ItemEntity->setPosition($newPosition);
        $ItemEntity->setUpdatedAt(new \DateTime());

        $this->entityManager->flush();
    }
}
