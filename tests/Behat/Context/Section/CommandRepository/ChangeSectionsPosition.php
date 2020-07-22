<?php

namespace App\Tests\Behat\Context\Section\CommandRepository;

use App\App\Doctrine\Entity\Section as SectionEntity;
use App\App\Doctrine\Repository\SectionRepository;
use App\App\Mapper\Section\DoctrineEntitySectionMapperInterface;
use App\Core\Model\Section\SectionInterface;
use App\Core\Repository\Section\SectionCommandRepositoryInterface;
use Behat\Behat\Context\Context;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use PHPUnit\Framework\Assert;

class ChangeSectionsPosition implements Context
{
    private const USER_ID = 1;

    /** @var int */
    private $positionToChange;
    /** @var int */
    private $currentPosition;
    /** @var SectionRepository */
    private $sectionRepository;
    /** @var DoctrineEntitySectionMapperInterface */
    private $sectionEntityMapper;
    /** @var SectionCommandRepositoryInterface */
    private $sectionCommandRepository;
    /** @var SectionEntity[] */
    private $sectionListState;
    /** @var SectionEntity[] */
    private $sectionList;
    /** @var Connection */
    private $doctrineConnection;
    /** @var bool */
    private $result = true;
    /** @var SectionEntity */
    private $sectionEntity;

    /**
     * ChangeSectionsPosition constructor.
     * @param SectionRepository $sectionRepository
     * @param DoctrineEntitySectionMapperInterface $sectionEntityMapper
     * @param SectionCommandRepositoryInterface $sectionCommandRepository
     * @param Connection $connection
     */
    public function __construct(
        SectionRepository $sectionRepository,
        DoctrineEntitySectionMapperInterface $sectionEntityMapper,
        SectionCommandRepositoryInterface $sectionCommandRepository,
        Connection $connection
    ) {
        $this->sectionRepository = $sectionRepository;
        $this->sectionEntityMapper = $sectionEntityMapper;
        $this->sectionCommandRepository = $sectionCommandRepository;
        $this->doctrineConnection = $connection;
    }

    /**
     * @param $currentPosition
     * @Given param with current position :currentPosition
     */
    public function paramWithCurrentPosition($currentPosition)
    {
        $this->currentPosition = (int)$currentPosition;
    }

    /**
     * @param $positionToChange
     * @Given param position :positionToChange which i want to change
     */
    public function paramPositionWhichIWantToChange($positionToChange)
    {
        $this->positionToChange = (int)$positionToChange;
    }

    /**
     * @When I call changePosition
     * @throws ConnectionException
     */
    public function iCallChangeposition()
    {
        $this->doctrineConnection->beginTransaction();

        $this->sectionEntity = $this->sectionRepository->findOneBy([
            'reportTemplateVersion' => '6647e03a-4f98-4a25-acc7-0ebad8fba230',
            'position' => $this->currentPosition
        ]);

        /** @var SectionInterface $section */
        $section = $this->sectionEntityMapper->map($this->sectionEntity);

        if ($this->currentPosition > $this->positionToChange) {
            $sectionListState =
                $this->sectionRepository->getListWhoNeedIncreaseInPosition($section, $this->positionToChange);
            /** @var SectionEntity $sectionState */
            foreach ($sectionListState as $sectionState) {
                $this->sectionListState[$sectionState->getId()] = $sectionState->getPosition();
            }
        } else {
            $sectionListState =
                $this->sectionRepository->getListWhoNeedDecreaseInPosition($section, $this->positionToChange);
            /** @var SectionEntity $sectionState */
            foreach ($sectionListState as $sectionState) {
                $this->sectionListState[$sectionState->getId()] = $sectionState->getPosition();
            }
        }
        $this->sectionCommandRepository->changePosition($section, $this->positionToChange, self::USER_ID);

        foreach ($this->sectionListState as $sectionId => $sectionPosition) {
            $this->sectionList[] = $this->sectionRepository->findOneBy(['id' => $sectionId]);
        }

        $this->doctrineConnection->rollBack();
    }

    /**
     * @Then compare state list section with increased list section
     */
    public function compareStateListSectionWithIncreasedListSection()
    {
        $this->getComparingForSectionList(true, false);
    }

    /**
     * @Then compare state list section with decreased list section
     */
    public function compareStateListSectionWithDecreasedListSection()
    {
        $this->getComparingForSectionList(false, true);
    }

    /**
     * @param bool $increased
     * @param bool $decreased
     */
    private function getComparingForSectionList($increased = false, $decreased = false): void
    {
        /** @var SectionEntity $sectionEntity */
        foreach ($this->sectionList as $sectionEntity) {
            /** @var int $currentSectionPosition */
            $currentSectionPosition = $sectionEntity->getPosition();
            /** @var int $stateSectionPosition */
            $stateSectionPosition = $this->sectionListState[$sectionEntity->getId()];

            if ($increased) {
                if ($stateSectionPosition - $currentSectionPosition != 1) {
                    $this->result = false;
                }
            }

            if ($decreased) {
                if ($currentSectionPosition - $stateSectionPosition != 1) {
                    $this->result = false;
                }
            }
        }

        if ($this->sectionEntity->getPosition() != $this->positionToChange) {
            $this->result = false;
        }

        Assert::assertEquals($this->result, true);
    }
}
