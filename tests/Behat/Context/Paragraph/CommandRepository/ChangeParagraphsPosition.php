<?php

namespace App\Tests\Behat\Context\Paragraph\CommandRepository;

use App\App\Doctrine\Entity\Paragraph as ParagraphEntity;
use App\App\Doctrine\Repository\ParagraphRepository;
use App\App\Mapper\Paragraph\DoctrineEntityParagraphMapperInterface;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Repository\Paragraph\ParagraphCommandRepositoryInterface;
use Behat\Behat\Context\Context;
use Doctrine\DBAL\Connection;
use PHPUnit\Framework\Assert;

class ChangeParagraphsPosition implements Context
{
    private const USER_ID = 1;

    /** @var BaseParagraphInterface */
    private $paragraph;
    /** @var int */
    private $currentPosition;
    /** @var ParagraphRepository */
    private $paragraphRepository;
    /** @var Connection */
    private $doctrineConnection;
    /** @var ParagraphCommandRepositoryInterface */
    private $paragraphCommandRepository;
    /** @var DoctrineEntityParagraphMapperInterface */
    private $paragraphEntityMapper;
    /** @var int */
    private $positionToChange;
    /** @var ParagraphEntity[] */
    private $paragraphListState = null;
    /** @var ParagraphEntity[] */
    private $paragraphList = null;
    /** @var bool */
    private $result = true;
    /** @var ParagraphEntity */
    private $paragraphEntity;

    /**
     * ChangeParagraphsPosition constructor.
     * @param Connection $connection
     * @param ParagraphRepository $paragraphRepository
     * @param ParagraphCommandRepositoryInterface $paragraphCommandRepository
     * @param DoctrineEntityParagraphMapperInterface $paragraphEntityMapper
     */
    public function __construct(
        Connection $connection,
        ParagraphRepository $paragraphRepository,
        ParagraphCommandRepositoryInterface $paragraphCommandRepository,
        DoctrineEntityParagraphMapperInterface $paragraphEntityMapper
    ) {
        $this->doctrineConnection = $connection;
        $this->paragraphRepository = $paragraphRepository;
        $this->paragraphCommandRepository = $paragraphCommandRepository;
        $this->paragraphEntityMapper = $paragraphEntityMapper;
    }


    /**
     * @param $currentPosition
     *
     * @Given param with current position :currentPosition
     */
    public function paramWithCurrentPosition($currentPosition)
    {
        $this->currentPosition = (int)$currentPosition;
    }

    /**
     * @param $level
     * @Given Paragraph with :level level
     */
    public function paragraphWithLevel($level)
    {
        if ($level == 1) {
            if ($this->currentPosition == 1) {
                $this->paragraphEntity = $this->paragraphRepository->find('63bea125-46f1-4d59-b6ec-13000d13ac9f');
            }
            if ($this->currentPosition == 4) {
                $this->paragraphEntity = $this->paragraphRepository->find('63bea125-46f1-4d59-b6ec-13003d13ac9f');
            }
        }

        if ($level == 2) {
            if ($this->currentPosition == 1) {
                $this->paragraphEntity = $this->paragraphRepository->find('63bea125-46f1-4d59-b6ec-13005d13ac9f');
            }
            if ($this->currentPosition == 3) {
                $this->paragraphEntity = $this->paragraphRepository->find('63bea125-46f1-4d59-b6ec-13007d13ac9f');
            }
        }

        if ($level == 3) {
            if ($this->currentPosition == 1) {
                $this->paragraphEntity = $this->paragraphRepository->find('63bea125-46f1-4d59-b6ec-13008d13ac9f');
            }
            if ($this->currentPosition == 3) {
                $this->paragraphEntity = $this->paragraphRepository->find('63bea125-46f1-4d59-b6ec-13010d13ac9f');
            }
        }

        $this->paragraph = $this->paragraphEntityMapper->map($this->paragraphEntity);
    }

    /**
     * @param $positionToChange
     *
     * @Given param position :positionToChange which i want to change
     */
    public function paramPositionWhichIWantToChange($positionToChange)
    {
        $this->positionToChange = (int)$positionToChange;
    }

    /**
     * @When I call changePosition
     */
    public function iCallChangeposition()
    {
        $this->doctrineConnection->beginTransaction();

        if ($this->currentPosition > $this->positionToChange) {
            /** @var ParagraphEntity[] $paragraphListState */
            $paragraphListState = $this->prepareParagraphListStateWhoNeedIncreaseInPosition();
            /** @var ParagraphEntity $paragraphState */
            foreach ($paragraphListState as $paragraphState) {
                $this->paragraphListState[$paragraphState->getId()] = $paragraphState->getPosition();
            }
        } else {
            /** @var ParagraphEntity[] $paragraphListState */
            $paragraphListState = $this->prepareParagraphListStateWhoNeedDecreaseInPosition();

            /** @var ParagraphEntity $paragraphState */
            foreach ($paragraphListState as $paragraphState) {
                $this->paragraphListState[$paragraphState->getId()] = $paragraphState->getPosition();
            }
        }

        $this->paragraphCommandRepository->changePosition(
            $this->paragraph,
            $this->positionToChange,
            self::USER_ID
        );

        foreach ($this->paragraphListState as $paragraphId => $paragraphPosition) {
            $this->paragraphList[] = $this->paragraphRepository->find(['id' => $paragraphId]);
        }

        $this->doctrineConnection->rollBack();
    }

    /**
     * @Then compare state list paragraph with increased list paragraph
     */
    public function compareStateListParagraphWithIncreasedListParagraph()
    {
        $this->getComparingForParagraphList(true, false);
    }

    /**
     * @Then compare state list paragraph with decreased list paragraph
     */
    public function compareStateListParagraphWithDecreasedListParagraph()
    {
        $this->getComparingForParagraphList(false, true);
    }

    /**
     * @return array
     */
    private function prepareParagraphListStateWhoNeedIncreaseInPosition(): array
    {
        return $this->paragraphRepository->getListWhoNeedIncreaseInPosition(
            $this->paragraph,
            $this->positionToChange
        );
    }

    /**
     * @return array
     */
    private function prepareParagraphListStateWhoNeedDecreaseInPosition(): array
    {
        return $this->paragraphRepository->getListWhoNeedDecreaseInPosition(
            $this->paragraph,
            $this->positionToChange
        );
    }

    /**
     * @param bool $increased
     * @param bool $decreased
     */
    private function getComparingForParagraphList($increased = false, $decreased = false): void
    {
        /** @var ParagraphEntity $paragraphEntity */
        foreach ($this->paragraphList as $paragraphEntity) {
            /** @var int $currentParagraphPosition */
            $currentParagraphPosition = $paragraphEntity->getPosition();
            /** @var int $stateParagraphPosition */
            $stateParagraphPosition = $this->paragraphListState[$paragraphEntity->getId()];

            if ($increased) {
                if ($stateParagraphPosition - $currentParagraphPosition != 1) {
                    $this->result = false;
                }
            }

            if ($decreased) {
                if ($currentParagraphPosition - $stateParagraphPosition != 1) {
                    $this->result = false;
                }
            }
        }

        if ($this->paragraphEntity->getPosition() != $this->positionToChange) {
            $this->result = false;
        }

        Assert::assertEquals($this->result, true);
    }
}
